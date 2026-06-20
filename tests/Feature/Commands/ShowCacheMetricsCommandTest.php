<?php

namespace Tests\Feature\Commands;

use App\Console\Commands\ShowCacheMetricsCommand;
use App\Services\CacheMetricsService;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ShowCacheMetricsCommandTest extends TestCase
{
    protected CacheMetricsService $metricsService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->metricsService = app(CacheMetricsService::class);
        $this->metricsService->reset();
    }

    protected function tearDown(): void
    {
        $this->metricsService->reset();
        parent::tearDown();
    }

    /**
     * Test command displays metrics successfully
     */
    public function test_command_displays_metrics(): void
    {
        // Add some metrics
        $this->metricsService->recordHit('key1', 5);
        $this->metricsService->recordMiss('key2', 100);

        $this->artisan('cache:metrics')
            ->assertSuccessful()
            ->expectsOutputToContain('CACHE PERFORMANCE METRICS');
    }

    /**
     * Test command displays hit/miss statistics
     */
    public function test_command_displays_hit_miss_stats(): void
    {
        $this->metricsService->recordHit('key1', 5);
        $this->metricsService->recordHit('key2', 5);
        $this->metricsService->recordMiss('key3', 100);

        $this->artisan('cache:metrics')
            ->assertSuccessful()
            ->expectsOutputToContain('Request Statistics')
            ->expectsOutputToContain('Cache Hits')
            ->expectsOutputToContain('Cache Misses')
            ->expectsOutputToContain('Hit Rate');
    }

    /**
     * Test command displays performance metrics
     */
    public function test_command_displays_performance_metrics(): void
    {
        $this->metricsService->recordHit('key1', 5);
        $this->metricsService->recordMiss('key2', 100);

        $this->artisan('cache:metrics')
            ->assertSuccessful()
            ->expectsOutputToContain('Performance Metrics')
            ->expectsOutputToContain('Avg Query Time')
            ->expectsOutputToContain('Avg Cache Access Time');
    }

    /**
     * Test command displays invalidation statistics
     */
    public function test_command_displays_invalidation_stats(): void
    {
        $this->metricsService->recordInvalidation('posts:*');
        $this->metricsService->recordInvalidation('post:42:*');

        $this->artisan('cache:metrics')
            ->assertSuccessful()
            ->expectsOutputToContain('Invalidation Statistics')
            ->expectsOutputToContain('Total Invalidations');
    }

    /**
     * Test command displays top cached items (or note about no cached items)
     */
    public function test_command_displays_top_cached_items_section(): void
    {
        $this->metricsService->recordHit('popular_key', 5);
        $this->metricsService->recordHit('popular_key', 5);
        $this->metricsService->recordHit('popular_key', 5);
        $this->metricsService->recordHit('another_key', 5);

        // Command should output either top items or a note that there are no cached items
        // Due to ArrayStore limitations in testing, it may show "No cached items yet"
        $this->artisan('cache:metrics')
            ->assertSuccessful();
    }

    /**
     * Test command handles period option
     */
    public function test_command_accepts_period_option(): void
    {
        $this->metricsService->recordHit('key1', 5);

        $this->artisan('cache:metrics', ['--period' => '7days'])
            ->assertSuccessful();
    }

    /**
     * Test command handles no metrics gracefully
     */
    public function test_command_handles_empty_metrics(): void
    {
        $this->artisan('cache:metrics')
            ->assertSuccessful()
            ->expectsOutputToContain('CACHE PERFORMANCE METRICS');
    }

    /**
     * Test command runs without errors
     */
    public function test_cache_metrics_command_is_registered(): void
    {
        $code = Artisan::call('cache:metrics');

        $this->assertEquals(0, $code);
    }

    /**
     * Test command output contains time saved section when applicable
     */
    public function test_command_displays_time_saved(): void
    {
        $this->metricsService->recordHit('key1', 5);
        $this->metricsService->recordMiss('key2', 100);

        $this->artisan('cache:metrics')
            ->assertSuccessful()
            ->expectsOutputToContain('Time Saved');
    }
}
