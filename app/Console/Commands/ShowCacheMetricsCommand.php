<?php

namespace App\Console\Commands;

use App\Services\CacheMetricsService;
use Illuminate\Console\Command;

/**
 * ShowCacheMetricsCommand
 *
 * Artisan command to display cache performance metrics.
 * Usage: php artisan cache:metrics
 */
class ShowCacheMetricsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:metrics {--period=today : Period to show metrics for (today, 7days, 30days)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display cache performance metrics including hit rate, time saved, and invalidations';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $metricsService = app(CacheMetricsService::class);
        $period = $this->option('period');

        // Get overall metrics
        $metrics = $metricsService->getMetrics($period);

        $this->info('');
        $this->info('═══════════════════════════════════════════════════════════');
        $this->info('  CACHE PERFORMANCE METRICS');
        $this->info('═══════════════════════════════════════════════════════════');
        $this->info('');

        // Display hit rate and request stats
        $this->displayHitRateStats($metrics);

        // Display time savings
        $this->displayTimeSavings($metrics);

        // Display invalidation stats
        $this->displayInvalidationStats($metrics);

        // Display top cached items
        $this->displayTopCachedItems($metricsService);

        // Display invalidation frequency
        $this->displayInvalidationFrequency($metricsService);

        $this->info('');
        $this->info('═══════════════════════════════════════════════════════════');
        $this->info('');

        return Command::SUCCESS;
    }

    /**
     * Display hit rate and request statistics
     *
     * @param array $metrics Metrics data
     * @return void
     */
    protected function displayHitRateStats(array $metrics): void
    {
        $hitRate = $metrics['hit_rate'];
        $statusIcon = $hitRate >= 80 ? '✓' : ($hitRate >= 50 ? '~' : '✗');

        $this->line('  Request Statistics');
        $this->line('  ─────────────────────────────────────────────────────────');

        $headers = ['Metric', 'Value'];
        $rows = [
            ['Total Requests', $metrics['total_requests']],
            ['Cache Hits', $metrics['hits']],
            ['Cache Misses', $metrics['misses']],
            [$statusIcon . ' Hit Rate', round($metrics['hit_rate'], 2) . '%'],
        ];

        $this->table($headers, $rows);
        $this->info('');
    }

    /**
     * Display time savings and performance metrics
     *
     * @param array $metrics Metrics data
     * @return void
     */
    protected function displayTimeSavings(array $metrics): void
    {
        $this->line('  Performance Metrics');
        $this->line('  ─────────────────────────────────────────────────────────');

        $headers = ['Metric', 'Value'];
        $rows = [
            ['Avg Query Time (miss)', $metrics['avg_query_time_ms'] . 'ms'],
            ['Avg Cache Access Time (hit)', $metrics['avg_cache_time_ms'] . 'ms'],
            ['Total Query Time', $metrics['total_query_time_ms'] . 'ms'],
            ['Total Cache Access Time', $metrics['total_cache_time_ms'] . 'ms'],
        ];

        $this->table($headers, $rows);

        // Calculate and display time saved
        $savings = $metrics['total_query_time_ms'] - $metrics['total_cache_time_ms'];
        if ($savings > 0) {
            $savingsPercent = round(($savings / $metrics['total_query_time_ms']) * 100, 2);
            $this->line('');
            $this->line('  Time Saved by Caching');
            $this->line('  ─────────────────────────────────────────────────────────');
            $this->line("  <fg=green>Total: {$savings}ms ({$savingsPercent}%)</>");
        }
        $this->info('');
    }

    /**
     * Display invalidation statistics
     *
     * @param array $metrics Metrics data
     * @return void
     */
    protected function displayInvalidationStats(array $metrics): void
    {
        $this->line('  Invalidation Statistics');
        $this->line('  ─────────────────────────────────────────────────────────');

        $headers = ['Metric', 'Value'];
        $rows = [
            ['Total Invalidations', $metrics['invalidations']],
        ];

        $this->table($headers, $rows);
        $this->info('');
    }

    /**
     * Display top cached items by hit count
     *
     * @param CacheMetricsService $metricsService Metrics service
     * @return void
     */
    protected function displayTopCachedItems(CacheMetricsService $metricsService): void
    {
        $topItems = $metricsService->getTopCachedItems(10);

        if (empty($topItems)) {
            $this->line('  <comment>No cached items yet</comment>');
            $this->info('');
            return;
        }

        $this->line('  Top 10 Cached Items (by hits)');
        $this->line('  ─────────────────────────────────────────────────────────');

        $headers = ['Cache Key', 'Hits', 'Misses', 'Last Hit'];
        $rows = [];

        foreach ($topItems as $item) {
            $rows[] = [
                substr($item['key'], 0, 40) . (strlen($item['key']) > 40 ? '...' : ''),
                $item['hits'],
                $item['misses'],
                $item['last_hit'],
            ];
        }

        $this->table($headers, $rows);
        $this->info('');
    }

    /**
     * Display invalidation frequency by pattern
     *
     * @param CacheMetricsService $metricsService Metrics service
     * @return void
     */
    protected function displayInvalidationFrequency(CacheMetricsService $metricsService): void
    {
        $frequency = $metricsService->getInvalidationFrequency();

        if (empty($frequency)) {
            $this->line('  <comment>No invalidations yet</comment>');
            $this->info('');
            return;
        }

        $this->line('  Invalidation Frequency (by pattern)');
        $this->line('  ─────────────────────────────────────────────────────────');

        $headers = ['Pattern', 'Count'];
        $rows = [];

        foreach ($frequency as $pattern => $count) {
            $rows[] = [$pattern, $count];
        }

        $this->table($headers, $rows);
        $this->info('');
    }
}
