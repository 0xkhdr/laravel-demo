<?php

namespace Tests\Unit\Observers;

use PHPUnit\Framework\TestCase;
use App\Observers\PostObserver;
use App\Repositories\PostRepository;
use Mockery;

class PostObserverTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Test that PostObserver can be instantiated.
     */
    public function test_post_observer_can_be_instantiated(): void
    {
        $mockRepository = Mockery::mock(PostRepository::class);
        $observer = new PostObserver($mockRepository);

        $this->assertInstanceOf(PostObserver::class, $observer);
    }

    /**
     * Test that the created event triggers cache flush for posts:* pattern.
     */
    public function test_created_event_triggers_cache_flush(): void
    {
        // Create a mock to track flush calls
        $mockRepository = Mockery::mock(PostRepository::class);
        $flushCalls = [];
        $mockRepository->shouldReceive('flush')->andReturnUsing(function ($pattern) use (&$flushCalls) {
            $flushCalls[] = $pattern;
        });

        // Create a mock post with just the id attribute
        $post = new \stdClass();
        $post->id = 1;

        $observer = new PostObserver($mockRepository);
        $observer->created($post);

        $this->assertContains('posts:*', $flushCalls);
    }

    /**
     * Test that the updated event triggers cache flush for both patterns.
     */
    public function test_updated_event_triggers_cache_flush_for_both_patterns(): void
    {
        // Create a mock to track flush calls
        $mockRepository = Mockery::mock(PostRepository::class);
        $flushCalls = [];
        $mockRepository->shouldReceive('flush')->andReturnUsing(function ($pattern) use (&$flushCalls) {
            $flushCalls[] = $pattern;
        });

        // Create a mock post
        $post = new \stdClass();
        $post->id = 123;

        // Use the mock observer
        $observer = new PostObserver($mockRepository);
        $observer->updated($post);

        $this->assertContains('posts:*', $flushCalls);
        $this->assertContains("post:123:*", $flushCalls);
    }

    /**
     * Test that the deleted event triggers cache flush for both patterns.
     */
    public function test_deleted_event_triggers_cache_flush_for_both_patterns(): void
    {
        // Create a mock to track flush calls
        $mockRepository = Mockery::mock(PostRepository::class);
        $flushCalls = [];
        $mockRepository->shouldReceive('flush')->andReturnUsing(function ($pattern) use (&$flushCalls) {
            $flushCalls[] = $pattern;
        });

        // Create a mock post
        $post = new \stdClass();
        $post->id = 456;

        // Use the mock observer
        $observer = new PostObserver($mockRepository);
        $observer->deleted($post);

        $this->assertContains('posts:*', $flushCalls);
        $this->assertContains("post:456:*", $flushCalls);
    }

    /**
     * Test that observer is called with correct cache keys for created event.
     */
    public function test_created_event_uses_correct_cache_key_pattern(): void
    {
        $mockRepository = Mockery::mock(PostRepository::class);
        $flushCalls = [];
        $mockRepository->shouldReceive('flush')->andReturnUsing(function ($pattern) use (&$flushCalls) {
            $flushCalls[] = $pattern;
        });

        $post = new \stdClass();
        $post->id = 42;

        $observer = new PostObserver($mockRepository);
        $observer->created($post);

        $this->assertContains('posts:*', $flushCalls);
    }

    /**
     * Test that observer is called with correct cache keys for updated event.
     */
    public function test_updated_event_uses_correct_cache_key_patterns(): void
    {
        $mockRepository = Mockery::mock(PostRepository::class);
        $flushCalls = [];
        $mockRepository->shouldReceive('flush')->andReturnUsing(function ($pattern) use (&$flushCalls) {
            $flushCalls[] = $pattern;
        });

        $post = new \stdClass();
        $post->id = 99;

        $observer = new PostObserver($mockRepository);
        $observer->updated($post);

        $this->assertContains('posts:*', $flushCalls);
        $this->assertContains("post:99:*", $flushCalls);
    }

    /**
     * Test that flush is called with correct post ID format.
     */
    public function test_flush_called_with_correct_post_id_format(): void
    {
        $mockRepository = Mockery::mock(PostRepository::class);
        $flushCalls = [];
        $mockRepository->shouldReceive('flush')->andReturnUsing(function ($pattern) use (&$flushCalls) {
            $flushCalls[] = $pattern;
        });

        $post = new \stdClass();
        $post->id = 777;

        $observer = new PostObserver($mockRepository);
        $observer->updated($post);

        $this->assertContains("post:777:*", $flushCalls);
    }

    /**
     * Test that PostObserver has the correct method signatures.
     */
    public function test_observer_has_created_method(): void
    {
        $mockRepository = Mockery::mock(PostRepository::class);
        $observer = new PostObserver($mockRepository);

        $this->assertTrue(method_exists($observer, 'created'));
        $this->assertTrue(method_exists($observer, 'updated'));
        $this->assertTrue(method_exists($observer, 'deleted'));
    }

    /**
     * Test that observer methods accept Post model.
     */
    public function test_observer_methods_execute_without_errors(): void
    {
        $mockRepository = Mockery::mock(PostRepository::class);
        $mockRepository->shouldReceive('flush')->andReturn(null);

        $post = new \stdClass();
        $post->id = 1;

        $observer = new PostObserver($mockRepository);

        // These should not throw any exceptions
        try {
            $observer->created($post);
            $observer->updated($post);
            $observer->deleted($post);
            $this->assertTrue(true); // Success if no exception
        } catch (\Exception $e) {
            $this->fail("Observer execution threw exception: " . $e->getMessage());
        }
    }

    /**
     * Test that created event calls flush exactly once with correct pattern.
     */
    public function test_created_event_calls_flush_once_with_posts_pattern(): void
    {
        $mockRepository = Mockery::mock(PostRepository::class);
        $callCount = 0;
        $mockRepository->shouldReceive('flush')
            ->times(1)
            ->with('posts:*')
            ->andReturnUsing(function () use (&$callCount) {
                $callCount++;
            });

        $post = new \stdClass();
        $post->id = 1;

        $observer = new PostObserver($mockRepository);
        $observer->created($post);

        $this->assertEquals(1, $callCount);
    }

    /**
     * Test that updated event calls flush exactly twice.
     */
    public function test_updated_event_calls_flush_twice(): void
    {
        $mockRepository = Mockery::mock(PostRepository::class);
        $flushCount = 0;
        $mockRepository->shouldReceive('flush')->andReturnUsing(function () use (&$flushCount) {
            $flushCount++;
        });

        $post = new \stdClass();
        $post->id = 1;

        $observer = new PostObserver($mockRepository);
        $observer->updated($post);

        $this->assertEquals(2, $flushCount);
    }

    /**
     * Test that deleted event calls flush exactly twice.
     */
    public function test_deleted_event_calls_flush_twice(): void
    {
        $mockRepository = Mockery::mock(PostRepository::class);
        $flushCount = 0;
        $mockRepository->shouldReceive('flush')->andReturnUsing(function () use (&$flushCount) {
            $flushCount++;
        });

        $post = new \stdClass();
        $post->id = 1;

        $observer = new PostObserver($mockRepository);
        $observer->deleted($post);

        $this->assertEquals(2, $flushCount);
    }
}
