<?php

namespace App\Http\Middleware;

use App\Services\CacheMetricsService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

/**
 * CacheMetricsMiddleware
 *
 * Tracks cache metrics for HTTP requests.
 * Records cache hits/misses and attaches metrics to response headers.
 */
class CacheMetricsMiddleware
{
    /**
     * CacheMetricsService instance
     *
     * @var CacheMetricsService
     */
    protected CacheMetricsService $metricsService;

    /**
     * Create the middleware instance
     *
     * @param CacheMetricsService $metricsService
     */
    public function __construct(CacheMetricsService $metricsService)
    {
        $this->metricsService = $metricsService;
    }

    /**
     * Handle an incoming request
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Start timing the request
        $startTime = microtime(true);

        // Process the request
        $response = $next($request);

        // Calculate request duration
        $duration = microtime(true) - $startTime;
        $durationMs = (int) round($duration * 1000);

        // Determine if this was a cache hit or miss based on response headers or custom markers
        $cacheStatus = $this->determineCacheStatus($request, $response);

        // Record metrics
        if ($cacheStatus === 'hit') {
            $this->metricsService->recordHit($this->getCacheKey($request), $durationMs);
        } elseif ($cacheStatus === 'miss') {
            $this->metricsService->recordMiss($this->getCacheKey($request), $durationMs);
        }

        // Attach metrics to response headers if enabled
        if (config('cache.metrics.attach_headers', false)) {
            $response = $this->attachMetricsToHeaders($response);
        }

        return $response;
    }

    /**
     * Determine cache status (hit or miss) from request/response
     *
     * @param Request $request
     * @param Response $response
     * @return string|null Cache status: 'hit', 'miss', or null
     */
    protected function determineCacheStatus(Request $request, Response $response): ?string
    {
        // Check for X-Cache header in response
        if ($response->headers->has('X-Cache')) {
            $xCache = $response->headers->get('X-Cache');
            if (strpos($xCache, 'hit') !== false) {
                return 'hit';
            } elseif (strpos($xCache, 'miss') !== false) {
                return 'miss';
            }
        }

        // Check for custom cache metrics header set by handlers
        if ($response->headers->has('X-Cache-Metrics')) {
            $metrics = $response->headers->get('X-Cache-Metrics');
            if (strpos($metrics, 'cached') !== false) {
                return 'hit';
            } elseif (strpos($metrics, 'computed') !== false) {
                return 'miss';
            }
        }

        // Default: consider non-200 responses and non-GET requests as misses
        if ($request->method() !== 'GET' || $response->getStatusCode() !== 200) {
            return 'miss';
        }

        // Default to miss if no cache indication found
        return null;
    }

    /**
     * Get cache key from request
     *
     * @param Request $request
     * @return string Cache key based on request path and query
     */
    protected function getCacheKey(Request $request): string
    {
        $path = $request->path();
        $query = $request->query();

        // Create key from path and important query params
        if (!empty($query)) {
            $queryHash = md5(json_encode($query));
            return "{$path}:{$queryHash}";
        }

        return $path;
    }

    /**
     * Attach cache metrics to response headers
     *
     * @param Response $response
     * @return Response
     */
    protected function attachMetricsToHeaders(Response $response): Response
    {
        $hitRate = round($this->metricsService->getHitRate(), 2);
        $savings = round($this->metricsService->getSavings(), 0);

        $response->headers->set('X-Cache-Hit-Rate', "{$hitRate}%");
        $response->headers->set('X-Cache-Time-Saved', "{$savings}ms");

        return $response;
    }
}
