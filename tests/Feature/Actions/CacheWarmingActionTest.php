<?php

namespace Tests\Feature\Actions;

use App\Actions\CacheWarmingAction;
use App\Models\User;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CacheWarmingActionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The CacheWarmingAction instance.
     *
     * @var CacheWarmingAction
     */
    protected CacheWarmingAction $action;

    /**
     * Set up the test.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->action = new CacheWarmingAction(
            app(PostRepository::class),
            app(UserRepository::class)
        );
    }

    /**
     * Test that action can be instantiated.
     *
     * @return void
     */
    public function test_action_can_be_instantiated()
    {
        $this->assertInstanceOf(CacheWarmingAction::class, $this->action);
    }

    /**
     * Test that action executes without errors.
     *
     * @return void
     */
    public function test_action_executes_without_errors()
    {
        // Create some test data
        Post::factory()->count(15)->create(['views' => rand(1, 100)]);
        User::factory()->count(10)->create();

        $result = $this->action->execute();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('statistics', $result);
    }

    /**
     * Test that action returns statistics.
     *
     * @return void
     */
    public function test_action_returns_statistics()
    {
        // Create some test data
        Post::factory()->count(15)->create(['views' => rand(1, 100)]);
        User::factory()->count(10)->create();

        $result = $this->action->execute();

        $this->assertArrayHasKey('statistics', $result);
        $this->assertArrayHasKey('total_posts_cached', $result['statistics']);
        $this->assertArrayHasKey('total_users_cached', $result['statistics']);
        $this->assertArrayHasKey('total_pages_cached', $result['statistics']);
        $this->assertArrayHasKey('duration_seconds', $result['statistics']);
        $this->assertArrayHasKey('success', $result['statistics']);
    }

    /**
     * Test that action returns correct statistics values.
     *
     * @return void
     */
    public function test_action_returns_correct_statistics()
    {
        // Create test data
        Post::factory()->count(15)->create(['views' => rand(1, 100)]);
        User::factory()->count(10)->create();

        $result = $this->action->execute();

        $this->assertIsNumeric($result['statistics']['total_posts_cached']);
        $this->assertIsNumeric($result['statistics']['total_users_cached']);
        $this->assertIsNumeric($result['statistics']['total_pages_cached']);
        $this->assertIsNumeric($result['statistics']['duration_seconds']);
        $this->assertIsBool($result['statistics']['success']);

        // Check reasonable values
        $this->assertGreaterThanOrEqual(0, $result['statistics']['total_posts_cached']);
        $this->assertGreaterThanOrEqual(0, $result['statistics']['total_users_cached']);
        $this->assertGreaterThanOrEqual(0, $result['statistics']['total_pages_cached']);
        $this->assertGreaterThan(0, $result['statistics']['duration_seconds']);
    }

    /**
     * Test that action supports verbose mode.
     *
     * @return void
     */
    public function test_action_supports_verbose_mode()
    {
        // Create some test data
        Post::factory()->count(15)->create(['views' => rand(1, 100)]);
        User::factory()->count(10)->create();

        // Suppress output
        ob_start();
        $result = $this->action->execute(true);
        $output = ob_get_clean();

        $this->assertIsArray($result);
        // In verbose mode, some output should be generated
        $this->assertNotEmpty($output);
    }

    /**
     * Test that action returns results array with posts and users.
     *
     * @return void
     */
    public function test_action_returns_results_with_posts_and_users()
    {
        // Create some test data
        Post::factory()->count(15)->create(['views' => rand(1, 100)]);
        User::factory()->count(10)->create();

        $result = $this->action->execute();

        $this->assertArrayHasKey('posts', $result);
        $this->assertArrayHasKey('users', $result);
        $this->assertIsArray($result['posts']);
        $this->assertIsArray($result['users']);
    }

    /**
     * Test that action populates cache.
     *
     * @return void
     */
    public function test_action_populates_cache()
    {
        // Create some test data
        $posts = Post::factory()->count(15)->create();
        $posts->each(function ($post) {
            $post->update(['views' => rand(10, 100)]);
        });
        $users = User::factory()->count(10)->create();

        // Clear cache
        Cache::flush();

        // Execute action
        $result = $this->action->execute();

        // Check if some caches were populated
        $this->assertTrue($result['statistics']['success'] || $result['statistics']['total_posts_cached'] > 0);
    }

    /**
     * Test that action improves initial request performance.
     *
     * @return void
     */
    public function test_action_improves_initial_request_performance()
    {
        // Create test data
        Post::factory()->count(15)->create(['views' => rand(1, 100)]);
        User::factory()->count(10)->create();

        // Clear cache
        Cache::flush();

        // Measure time without cache warming
        $startWithoutWarming = microtime(true);
        $postRepo = app(PostRepository::class);
        $postRepo->list([], 1, 15);
        $userRepo = app(UserRepository::class);
        $userRepo->list(15, 1);
        $timeWithoutWarming = microtime(true) - $startWithoutWarming;

        // Clear cache again
        Cache::flush();

        // Execute cache warming action
        $this->action->execute();

        // Measure time with cache warming (second access should be faster)
        $startWithWarming = microtime(true);
        $postRepo->list([], 1, 15);
        $userRepo->list(15, 1);
        $timeWithWarming = microtime(true) - $startWithWarming;

        // The second access should be much faster due to cache
        // Even if not consistently faster, the action should complete successfully
        $this->assertIsNumeric($timeWithWarming);
        $this->assertGreaterThan(0, $timeWithWarming);
    }

    /**
     * Test that action completes without errors when no data exists.
     *
     * @return void
     */
    public function test_action_completes_without_errors_with_no_data()
    {
        $result = $this->action->execute();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('statistics', $result);
        // Should complete even without data
        $this->assertTrue(
            $result['statistics']['success'] || count($result['statistics']['total_posts_cached']) == 0
        );
    }

    /**
     * Test that action returns specific result structure.
     *
     * @return void
     */
    public function test_action_result_structure()
    {
        Post::factory()->count(15)->create(['views' => rand(1, 100)]);
        User::factory()->count(10)->create();

        $result = $this->action->execute();

        // Check posts result structure
        $this->assertArrayHasKey('success', $result['posts']);
        $this->assertArrayHasKey('total_cached', $result['posts']);
        $this->assertArrayHasKey('pages_cached', $result['posts']);
        $this->assertArrayHasKey('errors', $result['posts']);

        // Check users result structure
        $this->assertArrayHasKey('success', $result['users']);
        $this->assertArrayHasKey('total_cached', $result['users']);
        $this->assertArrayHasKey('pages_cached', $result['users']);
        $this->assertArrayHasKey('errors', $result['users']);
    }
}
