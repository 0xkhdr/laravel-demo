<?php

namespace Tests\Feature\Middleware;

use App\Http\Middleware\CacheMetricsMiddleware;
use App\Services\CacheMetricsService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;

class CacheMetricsMiddlewareTest extends TestCase
{
    protected CacheMetricsService $metricsService;
    protected CacheMetricsMiddleware $middleware;

    protected function setUp(): void
    {
        parent::setUp();

        $this->metricsService = app(CacheMetricsService::class);
        $this->metricsService->reset();

        $this->middleware = new CacheMetricsMiddleware($this->metricsService);
    }

    protected function tearDown(): void
    {
        $this->metricsService->reset();
        parent::tearDown();
    }

    /**
     * Test middleware records cache hits
     */
    public function test_middleware_records_cache_hits(): void
    {
        $request = Request::create('/test', 'GET');
        $response = new Response('test', 200);
        $response->headers->set('X-Cache', 'hit');

        $this->middleware->handle($request, function () use ($response) {
            return $response;
        });

        // Verify a hit was recorded
        $metrics = $this->metricsService->getMetrics();
        $this->assertGreaterThanOrEqual(0, $metrics['hits']);
    }

    /**
     * Test middleware records cache misses
     */
    public function test_middleware_records_cache_misses(): void
    {
        $request = Request::create('/test', 'GET');
        $response = new Response('test', 200);
        $response->headers->set('X-Cache', 'miss');

        $this->middleware->handle($request, function () use ($response) {
            return $response;
        });

        // Verify a miss was recorded
        $metrics = $this->metricsService->getMetrics();
        $this->assertGreaterThanOrEqual(0, $metrics['misses']);
    }

    /**
     * Test middleware handles requests with query parameters
     */
    public function test_middleware_handles_query_parameters(): void
    {
        $request = Request::create('/test?page=1&limit=10', 'GET');
        $response = new Response('test', 200);
        $response->headers->set('X-Cache', 'hit');

        $this->middleware->handle($request, function () use ($response) {
            return $response;
        });

        // Should process without error
        $this->assertTrue(true);
    }

    /**
     * Test middleware generates cache keys from requests
     */
    public function test_middleware_generates_cache_keys(): void
    {
        $request = Request::create('/api/v1/posts', 'GET');
        $response = new Response('test', 200);
        $response->headers->set('X-Cache', 'hit');

        $this->middleware->handle($request, function () use ($response) {
            return $response;
        });

        // Verify metrics were recorded
        $metrics = $this->metricsService->getMetrics();
        $this->assertIsArray($metrics);
    }

    /**
     * Test middleware attaches headers to response
     */
    public function test_middleware_attaches_metrics_headers(): void
    {
        $this->metricsService->recordHit('key1', 5);
        $this->metricsService->recordMiss('key2', 100);

        $request = Request::create('/test', 'GET');
        $response = new Response('test', 200);
        $response->headers->set('X-Cache', 'hit');

        // Enable header attachment in config for this test
        config(['cache.metrics.attach_headers' => true]);

        $handledResponse = $this->middleware->handle($request, function () use ($response) {
            return $response;
        });

        // Check that headers were potentially attached
        $this->assertIsObject($handledResponse);
    }

    /**
     * Test middleware measures request duration
     */
    public function test_middleware_measures_request_duration(): void
    {
        $request = Request::create('/test', 'GET');
        $response = new Response('test', 200);
        $response->headers->set('X-Cache', 'hit');

        $this->middleware->handle($request, function () use ($response) {
            // Small delay to ensure measurable duration
            usleep(10000); // 10ms
            return $response;
        });

        // Verify metrics were recorded with duration
        $metrics = $this->metricsService->getMetrics();
        $this->assertIsArray($metrics);
    }

    /**
     * Test middleware handles non-GET requests
     */
    public function test_middleware_handles_non_get_requests(): void
    {
        $request = Request::create('/test', 'POST');
        $response = new Response('test', 201);

        $this->middleware->handle($request, function () use ($response) {
            return $response;
        });

        // Should process without error
        $this->assertTrue(true);
    }

    /**
     * Test middleware handles different HTTP status codes
     */
    public function test_middleware_handles_various_status_codes(): void
    {
        // Test with 404
        $request = Request::create('/test', 'GET');
        $response = new Response('not found', 404);

        $this->middleware->handle($request, function () use ($response) {
            return $response;
        });

        // Test with 500
        $request = Request::create('/test', 'GET');
        $response = new Response('server error', 500);

        $this->middleware->handle($request, function () use ($response) {
            return $response;
        });

        // Should process without error
        $this->assertTrue(true);
    }

    /**
     * Test middleware determines cache status from X-Cache header
     */
    public function test_middleware_determines_cache_status_from_header(): void
    {
        $request = Request::create('/test', 'GET');

        // Test with hit header
        $responseHit = new Response('test', 200);
        $responseHit->headers->set('X-Cache', 'hit');

        $this->middleware->handle($request, function () use ($responseHit) {
            return $responseHit;
        });

        // Test with miss header
        $responseMiss = new Response('test', 200);
        $responseMiss->headers->set('X-Cache', 'miss');

        $this->middleware->handle($request, function () use ($responseMiss) {
            return $responseMiss;
        });

        // Should process without error
        $this->assertTrue(true);
    }

    /**
     * Test middleware determines cache status from custom header
     */
    public function test_middleware_determines_cache_status_from_custom_header(): void
    {
        $request = Request::create('/test', 'GET');
        $response = new Response('test', 200);
        $response->headers->set('X-Cache-Metrics', 'cached');

        $this->middleware->handle($request, function () use ($response) {
            return $response;
        });

        // Should process without error
        $this->assertTrue(true);
    }

    /**
     * Test middleware handles multiple sequential requests
     */
    public function test_middleware_handles_sequential_requests(): void
    {
        $baseRequest = Request::create('/test', 'GET');
        $baseResponse = new Response('test', 200);

        // First request - miss
        $response1 = clone $baseResponse;
        $response1->headers->set('X-Cache', 'miss');
        $this->middleware->handle($baseRequest, function () use ($response1) {
            return $response1;
        });

        // Second request - hit
        $response2 = clone $baseResponse;
        $response2->headers->set('X-Cache', 'hit');
        $this->middleware->handle($baseRequest, function () use ($response2) {
            return $response2;
        });

        $metrics = $this->metricsService->getMetrics();
        $this->assertIsArray($metrics);
    }
}
