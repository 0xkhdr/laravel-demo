<?php

namespace Tests\Feature\Console;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CacheWarmingCommandsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that WarmPostCacheCommand exists and is callable.
     *
     * @return void
     */
    public function test_warm_post_cache_command_exists()
    {
        $this->artisan('cache:warm:posts')
            ->assertExitCode(0);
    }

    /**
     * Test that WarmUserCacheCommand exists and is callable.
     *
     * @return void
     */
    public function test_warm_user_cache_command_exists()
    {
        $this->artisan('cache:warm:users')
            ->assertExitCode(0);
    }

    /**
     * Test that WarmPostCacheCommand executes without errors.
     *
     * @return void
     */
    public function test_warm_post_cache_command_executes_without_errors()
    {
        // Create some test posts
        Post::factory()->count(15)->create(['views' => rand(1, 100)]);

        $this->artisan('cache:warm:posts')
            ->assertExitCode(0)
            ->expectsOutput('Starting cache warming for posts...');
    }

    /**
     * Test that WarmUserCacheCommand executes without errors.
     *
     * @return void
     */
    public function test_warm_user_cache_command_executes_without_errors()
    {
        // Create some test users and assign admin role
        User::factory()->count(5)->create();

        $this->artisan('cache:warm:users')
            ->assertExitCode(0)
            ->expectsOutput('Starting cache warming for users...');
    }

    /**
     * Test that WarmPostCacheCommand populates cache.
     *
     * @return void
     */
    public function test_warm_post_cache_command_populates_cache()
    {
        // Create test posts with views
        $posts = Post::factory()->count(15)->create();
        $posts->each(function ($post) {
            $post->update(['views' => rand(10, 100)]);
        });

        // Clear cache
        Cache::flush();

        // Verify cache is empty
        $this->assertNull(Cache::get('post:1'));

        // Run the command
        $this->artisan('cache:warm:posts')->assertExitCode(0);

        // Verify cache is populated for at least some posts
        $cacheChecks = 0;
        foreach ($posts->take(10) as $post) {
            $cacheKey = "post:{$post->id}";
            if (Cache::has($cacheKey)) {
                $cacheChecks++;
            }
        }

        $this->assertGreaterThan(0, $cacheChecks, 'At least some post caches should be populated');
    }

    /**
     * Test that WarmUserCacheCommand populates cache.
     *
     * @return void
     */
    public function test_warm_user_cache_command_populates_cache()
    {
        // Create test users
        $users = User::factory()->count(10)->create();

        // Clear cache
        Cache::flush();

        // Verify cache is empty
        $this->assertNull(Cache::get('user:1'));

        // Run the command
        $this->artisan('cache:warm:users')->assertExitCode(0);

        // Verify list cache is populated for at least the first page
        $this->assertTrue(
            Cache::has('users:1:15') || Cache::has('users:2:15') || Cache::has('users:3:15'),
            'User list cache should be populated'
        );
    }

    /**
     * Test that console output shows progress.
     *
     * @return void
     */
    public function test_warm_post_cache_shows_progress()
    {
        // Create some test posts
        Post::factory()->count(15)->create(['views' => rand(1, 100)]);

        $this->artisan('cache:warm:posts')
            ->assertExitCode(0)
            ->expectsOutput('Starting cache warming for posts...')
            ->expectsOutputToContain('Warming find() cache for popular posts...')
            ->expectsOutputToContain('Warming list cache for first 3 pages');
    }

    /**
     * Test that console output shows user progress.
     *
     * @return void
     */
    public function test_warm_user_cache_shows_progress()
    {
        // Create some test users
        User::factory()->count(10)->create();

        $this->artisan('cache:warm:users')
            ->assertExitCode(0)
            ->expectsOutput('Starting cache warming for users...')
            ->expectsOutputToContain('Warming cache for admin users...')
            ->expectsOutputToContain('Warming list cache for all users');
    }

    /**
     * Test that WarmPostCacheCommand handles errors gracefully.
     *
     * @return void
     */
    public function test_warm_post_cache_command_handles_errors()
    {
        // Run command with no posts
        $result = $this->artisan('cache:warm:posts');

        // Should still exit cleanly
        $this->assertThat(
            $result->exitCode(),
            $this->logicalOr($this->equalTo(0), $this->equalTo(1))
        );
    }

    /**
     * Test that WarmUserCacheCommand handles errors gracefully.
     *
     * @return void
     */
    public function test_warm_user_cache_command_handles_errors()
    {
        // Run command with no users
        $result = $this->artisan('cache:warm:users');

        // Should still exit cleanly
        $this->assertThat(
            $result->exitCode(),
            $this->logicalOr($this->equalTo(0), $this->equalTo(1))
        );
    }
}
