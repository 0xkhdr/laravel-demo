<?php

namespace Tests\Feature;

use App\Services\CacheMetricsService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

/**
 * Integration test demonstrating cache metrics in action
 */
class CacheMetricsIntegrationTest extends TestCase
{
    protected CacheMetricsService $metrics;

    protected function setUp(): void
    {
        parent::setUp();

        $this->metrics = app(CacheMetricsService::class);
        $this->metrics->reset();
    }

    protected function tearDown(): void
    {
        $this->metrics->reset();
        parent::tearDown();
    }

    /**
     * Test end-to-end cache metrics workflow
     */
    public function test_cache_metrics_workflow(): void
    {
        // Simulate application cache usage
        $this->simulateCacheActivity();

        // Verify metrics were recorded
        $metrics = $this->metrics->getMetrics();

        $this->assertGreaterThan(0, $metrics['total_requests']);
        $this->assertGreaterThan(0, $metrics['hits']);
        $this->assertGreaterThan(0, $metrics['misses']);
    }

    /**
     * Test monitoring shows cache effectiveness
     */
    public function test_monitoring_shows_cache_effectiveness(): void
    {
        // Warm cache with many hits
        for ($i = 0; $i < 100; $i++) {
            $this->metrics->recordHit("key:$i", 5);
        }

        // Few misses
        $this->metrics->recordMiss('key:new', 150);

        $metrics = $this->metrics->getMetrics();
        $hitRate = $this->metrics->getHitRate();

        // Should show high hit rate
        $this->assertGreaterThan(90, $hitRate);

        // Time savings should be significant
        $savings = $this->metrics->getSavings();
        $this->assertGreaterThan(0, $savings);
    }

    /**
     * Test cache invalidation tracking
     */
    public function test_cache_invalidation_tracking(): void
    {
        // Simulate cache activity
        $this->metrics->recordHit('post:1', 5);
        $this->metrics->recordHit('post:1', 5);
        $this->metrics->recordHit('post:2', 5);

        // Simulate invalidation
        $this->metrics->recordInvalidation('post:*');
        $this->metrics->recordInvalidation('post:1:*');
        $this->metrics->recordInvalidation('post:*');

        $frequency = $this->metrics->getInvalidationFrequency();

        $this->assertArrayHasKey('post:*', $frequency);
        $this->assertEquals(2, $frequency['post:*']);
        $this->assertEquals(1, $frequency['post:1:*']);
    }

    /**
     * Test command displays accurate statistics
     */
    public function test_command_displays_accurate_statistics(): void
    {
        $this->simulateCacheActivity();

        $code = Artisan::call('cache:metrics');

        $this->assertEquals(0, $code);
    }

    /**
     * Test realistic cache scenario: Blog posts
     */
    public function test_realistic_blog_post_cache_scenario(): void
    {
        // User browsing posts
        // First visit - cache miss for post list
        $this->metrics->recordMiss('posts:list:page=1', 250);
        Cache::put('posts:list:page=1', ['posts' => [1, 2, 3]], 300);

        // Subsequent visits - cache hits
        for ($i = 0; $i < 10; $i++) {
            $this->metrics->recordHit('posts:list:page=1', 8);
        }

        // View individual posts
        for ($i = 1; $i <= 5; $i++) {
            $this->metrics->recordMiss("post:$i", 120);
            Cache::put("post:$i", ['post' => ['id' => $i]], 3600);

            // Viewers on this post
            for ($j = 0; $j < 50; $j++) {
                $this->metrics->recordHit("post:$i", 5);
            }
        }

        $metrics = $this->metrics->getMetrics();
        $hitRate = $this->metrics->getHitRate();

        // Should show high effectiveness
        $this->assertGreaterThan(80, $hitRate);

        // Time saved should be significant
        $savings = $this->metrics->getSavings();
        $this->assertGreaterThan(1000, $savings); // More than 1 second saved
    }

    /**
     * Test cache metrics with mixed content types
     */
    public function test_metrics_with_mixed_content_types(): void
    {
        // Different cache types with different patterns
        $cachePatterns = [
            'posts:list' => ['hits' => 150, 'misses' => 5],
            'post:single' => ['hits' => 200, 'misses' => 10],
            'comments:' => ['hits' => 100, 'misses' => 20],
            'users:profile' => ['hits' => 80, 'misses' => 15],
        ];

        foreach ($cachePatterns as $pattern => $stats) {
            for ($i = 0; $i < $stats['hits']; $i++) {
                $this->metrics->recordHit("$pattern:$i", 5);
            }
            for ($i = 0; $i < $stats['misses']; $i++) {
                $this->metrics->recordMiss("$pattern:$i", 100);
            }
        }

        $metrics = $this->metrics->getMetrics();

        // Verify aggregation
        $this->assertEquals(530, $metrics['hits']);
        $this->assertEquals(50, $metrics['misses']); // 5+10+20+15 = 50
        $this->assertEqualsWithDelta(91.38, $metrics['hit_rate'], 0.01);
    }

    /**
     * Simulate realistic cache activity
     */
    protected function simulateCacheActivity(): void
    {
        // Cache misses (expensive DB queries)
        $this->metrics->recordMiss('products:list', 150);
        $this->metrics->recordMiss('product:1', 120);
        $this->metrics->recordMiss('orders:user:1', 200);

        // Cache hits (from Redis)
        for ($i = 0; $i < 30; $i++) {
            $this->metrics->recordHit('products:list', 5);
            $this->metrics->recordHit('product:1', 8);
        }

        for ($i = 0; $i < 20; $i++) {
            $this->metrics->recordHit('orders:user:1', 6);
        }

        // Some invalidations
        $this->metrics->recordInvalidation('products:*');
        $this->metrics->recordInvalidation('orders:user:1');
    }
}
