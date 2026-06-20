<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * CacheMetricsService
 *
 * Tracks cache performance metrics including hits, misses, invalidations, and time savings.
 * Stores metrics in both Redis and database for analysis.
 */
class CacheMetricsService
{
    protected string $metricsPrefix = 'cache_metrics:';
    protected string $hitsKey = 'cache_metrics:hits';
    protected string $missesKey = 'cache_metrics:misses';
    protected string $invalidationsKey = 'cache_metrics:invalidations';
    protected string $queryTimeKey = 'cache_metrics:query_time';
    protected string $cacheTimeKey = 'cache_metrics:cache_time';

    /**
     * Record a cache hit
     *
     * @param string $key Cache key
     * @param int $durationMs Duration in milliseconds
     * @return void
     */
    public function recordHit(string $key, int $durationMs): void
    {
        // Record in Redis for real-time metrics
        Cache::increment($this->hitsKey, 1);
        Cache::increment($this->cacheTimeKey, $durationMs);

        // Store per-key metrics
        $keyMetrics = $this->getKeyMetrics($key);
        $keyMetrics['hits'] = ($keyMetrics['hits'] ?? 0) + 1;
        $keyMetrics['last_hit'] = now()->toDateTimeString();
        $this->setKeyMetrics($key, $keyMetrics);

        // Log to database for historical analysis
        $this->logMetricToDatabase('hit', $key, $durationMs);
    }

    /**
     * Record a cache miss
     *
     * @param string $key Cache key
     * @param int $durationMs Duration in milliseconds (query time)
     * @return void
     */
    public function recordMiss(string $key, int $durationMs): void
    {
        // Record in Redis for real-time metrics
        Cache::increment($this->missesKey, 1);
        Cache::increment($this->queryTimeKey, $durationMs);

        // Store per-key metrics
        $keyMetrics = $this->getKeyMetrics($key);
        $keyMetrics['misses'] = ($keyMetrics['misses'] ?? 0) + 1;
        $keyMetrics['last_miss'] = now()->toDateTimeString();
        $this->setKeyMetrics($key, $keyMetrics);

        // Log to database for historical analysis
        $this->logMetricToDatabase('miss', $key, $durationMs);
    }

    /**
     * Record a cache invalidation
     *
     * @param string $pattern Cache key pattern
     * @return void
     */
    public function recordInvalidation(string $pattern): void
    {
        // Increment invalidation counter
        Cache::increment($this->invalidationsKey, 1);

        // Store invalidation pattern with timestamp
        $invalidations = Cache::get($this->metricsPrefix . 'invalidations_log', []);
        $invalidations[] = [
            'pattern' => $pattern,
            'timestamp' => now()->toDateTimeString(),
        ];

        // Keep only last 1000 invalidations
        if (count($invalidations) > 1000) {
            $invalidations = array_slice($invalidations, -1000);
        }

        Cache::put($this->metricsPrefix . 'invalidations_log', $invalidations, now()->addDays(30));

        // Log to database
        $this->logMetricToDatabase('invalidation', $pattern, 0);
    }

    /**
     * Get metrics for a specific period
     *
     * @param string $period Period identifier (e.g., 'today', '7days', '30days')
     * @return array Metrics array
     */
    public function getMetrics(string $period = 'today'): array
    {
        $hits = Cache::get($this->hitsKey, 0);
        $misses = Cache::get($this->missesKey, 0);
        $invalidations = Cache::get($this->invalidationsKey, 0);
        $queryTime = Cache::get($this->queryTimeKey, 0);
        $cacheTime = Cache::get($this->cacheTimeKey, 0);

        $totalRequests = $hits + $misses;
        $hitRate = $totalRequests > 0 ? ($hits / $totalRequests) * 100 : 0;

        // Calculate average times
        $avgQueryTime = $misses > 0 ? $queryTime / $misses : 0;
        $avgCacheTime = $hits > 0 ? $cacheTime / $hits : 0;

        return [
            'period' => $period,
            'hits' => $hits,
            'misses' => $misses,
            'total_requests' => $totalRequests,
            'hit_rate' => round($hitRate, 2),
            'invalidations' => $invalidations,
            'avg_query_time_ms' => round($avgQueryTime, 2),
            'avg_cache_time_ms' => round($avgCacheTime, 2),
            'total_query_time_ms' => $queryTime,
            'total_cache_time_ms' => $cacheTime,
            'total_time_saved_ms' => max(0, ($queryTime - $cacheTime) * ($hits > 0 ? $hits : 0) / max($misses, 1)),
        ];
    }

    /**
     * Get overall cache hit rate
     *
     * @return float Hit rate percentage (0-100)
     */
    public function getHitRate(): float
    {
        $hits = Cache::get($this->hitsKey, 0);
        $misses = Cache::get($this->missesKey, 0);
        $totalRequests = $hits + $misses;

        return $totalRequests > 0 ? ($hits / $totalRequests) * 100 : 0;
    }

    /**
     * Get total time saved by caching
     *
     * Calculates the difference between total query time that would have been spent
     * if we had done DB queries for all cache hits, versus the actual cache access time.
     *
     * @return float Time saved in milliseconds
     */
    public function getSavings(): float
    {
        $queryTime = Cache::get($this->queryTimeKey, 0);
        $cacheTime = Cache::get($this->cacheTimeKey, 0);
        $hits = Cache::get($this->hitsKey, 0);
        $misses = Cache::get($this->missesKey, 0);

        if ($hits === 0 || $misses === 0) {
            return 0;
        }

        // Time saved = (avg query time - avg cache time) * number of hits
        // where avg query time is the average time spent on cache misses
        // and avg cache time is the average time spent on cache hits
        $avgQueryTime = $misses > 0 ? $queryTime / $misses : 0;
        $avgCacheTime = $hits > 0 ? $cacheTime / $hits : 0;

        $timeSaved = $avgQueryTime - $avgCacheTime;

        return max(0, $timeSaved * $hits);
    }

    /**
     * Get top cached items by hit count
     *
     * @param int $limit Number of top items to return
     * @return array Array of cached items with metrics
     */
    public function getTopCachedItems(int $limit = 10): array
    {
        $allKeys = [];
        $items = [];

        try {
            $store = Cache::getStore();

            // Try to get keys from Redis if available
            if (method_exists($store, 'connection')) {
                $connection = $store->connection();
                if (method_exists($connection, 'keys')) {
                    $allKeys = $connection->keys($this->metricsPrefix . 'key:*');
                }
            } elseif (method_exists($store, 'getAll')) {
                // For Array store, we can't efficiently get all keys, so return empty
                return [];
            }
        } catch (\Exception $e) {
            // Gracefully handle if Redis is not available
            return [];
        }

        foreach ($allKeys as $redisKey) {
            $key = str_replace($this->metricsPrefix . 'key:', '', $redisKey);
            $metrics = $this->getKeyMetrics($key);

            if (!empty($metrics)) {
                $items[] = [
                    'key' => $key,
                    'hits' => $metrics['hits'] ?? 0,
                    'misses' => $metrics['misses'] ?? 0,
                    'last_hit' => $metrics['last_hit'] ?? 'never',
                ];
            }
        }

        // Sort by hit count
        usort($items, function ($a, $b) {
            return $b['hits'] <=> $a['hits'];
        });

        return array_slice($items, 0, $limit);
    }

    /**
     * Get invalidation frequency by pattern
     *
     * @return array Array of patterns with their invalidation counts
     */
    public function getInvalidationFrequency(): array
    {
        $invalidations = Cache::get($this->metricsPrefix . 'invalidations_log', []);
        $frequency = [];

        foreach ($invalidations as $invalidation) {
            $pattern = $invalidation['pattern'];
            $frequency[$pattern] = ($frequency[$pattern] ?? 0) + 1;
        }

        // Sort by frequency
        arsort($frequency);

        return $frequency;
    }

    /**
     * Reset all metrics
     *
     * @return void
     */
    public function reset(): void
    {
        Cache::forget($this->hitsKey);
        Cache::forget($this->missesKey);
        Cache::forget($this->invalidationsKey);
        Cache::forget($this->queryTimeKey);
        Cache::forget($this->cacheTimeKey);
        Cache::forget($this->metricsPrefix . 'invalidations_log');

        // Clear all key-specific metrics
        try {
            $store = Cache::getStore();

            if (method_exists($store, 'connection')) {
                $connection = $store->connection();
                if (method_exists($connection, 'keys')) {
                    $allKeys = $connection->keys($this->metricsPrefix . 'key:*');
                    foreach ($allKeys as $key) {
                        Cache::forget($key);
                    }
                }
            }
        } catch (\Exception $e) {
            // Gracefully handle if Redis is not available
            // For array driver, keys will be cleared by garbage collection
        }
    }

    /**
     * Get metrics for a specific key
     *
     * @param string $key Cache key
     * @return array Key metrics
     */
    protected function getKeyMetrics(string $key): array
    {
        return Cache::get($this->metricsPrefix . "key:{$key}", []);
    }

    /**
     * Store metrics for a specific key
     *
     * @param string $key Cache key
     * @param array $metrics Metrics array
     * @return void
     */
    protected function setKeyMetrics(string $key, array $metrics): void
    {
        Cache::put($this->metricsPrefix . "key:{$key}", $metrics, now()->addDays(30));
    }

    /**
     * Log metric event to database
     *
     * @param string $type Metric type (hit, miss, invalidation)
     * @param string $key Cache key
     * @param int $durationMs Duration in milliseconds
     * @return void
     */
    protected function logMetricToDatabase(string $type, string $key, int $durationMs): void
    {
        try {
            DB::table('cache_metrics')->insert([
                'type' => $type,
                'cache_key' => $key,
                'duration_ms' => $durationMs,
                'created_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Silently fail if database logging is not available
            \Log::debug('Failed to log cache metrics to database: ' . $e->getMessage());
        }
    }
}
