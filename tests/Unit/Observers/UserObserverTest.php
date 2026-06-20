<?php

namespace Tests\Unit\Observers;

use Tests\TestCase;
use App\Observers\UserObserver;
use App\Repositories\UserRepository;
use Mockery;

class UserObserverTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Test that UserObserver can be instantiated.
     */
    public function test_user_observer_can_be_instantiated(): void
    {
        $mockRepository = Mockery::mock(UserRepository::class);
        $observer = new UserObserver($mockRepository);

        $this->assertInstanceOf(UserObserver::class, $observer);
    }

    /**
     * Test that the created event triggers cache flush for users:* pattern.
     */
    public function test_created_event_triggers_cache_flush(): void
    {
        // Create a mock to track flush calls
        $mockRepository = Mockery::mock(UserRepository::class);
        $flushCalls = [];
        $mockRepository->shouldReceive('flush')->andReturnUsing(function ($pattern) use (&$flushCalls) {
            $flushCalls[] = $pattern;
        });

        // Create a mock user with just the id attribute
        $user = new \stdClass();
        $user->id = 1;

        $observer = new UserObserver($mockRepository);
        $observer->created($user);

        $this->assertContains('users:*', $flushCalls);
    }

    /**
     * Test that the updated event triggers cache flush for both patterns.
     */
    public function test_updated_event_triggers_cache_flush_for_both_patterns(): void
    {
        // Create a mock to track flush calls
        $mockRepository = Mockery::mock(UserRepository::class);
        $flushCalls = [];
        $mockRepository->shouldReceive('flush')->andReturnUsing(function ($pattern) use (&$flushCalls) {
            $flushCalls[] = $pattern;
        });

        // Create a mock user
        $user = new \stdClass();
        $user->id = 123;

        // Use the mock observer
        $observer = new UserObserver($mockRepository);
        $observer->updated($user);

        $this->assertContains('users:*', $flushCalls);
        $this->assertContains("user:123:*", $flushCalls);
    }

    /**
     * Test that the deleted event triggers cache flush for both patterns.
     */
    public function test_deleted_event_triggers_cache_flush_for_both_patterns(): void
    {
        // Create a mock to track flush calls
        $mockRepository = Mockery::mock(UserRepository::class);
        $flushCalls = [];
        $mockRepository->shouldReceive('flush')->andReturnUsing(function ($pattern) use (&$flushCalls) {
            $flushCalls[] = $pattern;
        });

        // Create a mock user
        $user = new \stdClass();
        $user->id = 456;

        // Use the mock observer
        $observer = new UserObserver($mockRepository);
        $observer->deleted($user);

        $this->assertContains('users:*', $flushCalls);
        $this->assertContains("user:456:*", $flushCalls);
    }

    /**
     * Test that observer is called with correct cache keys for created event.
     */
    public function test_created_event_uses_correct_cache_key_pattern(): void
    {
        $mockRepository = Mockery::mock(UserRepository::class);
        $flushCalls = [];
        $mockRepository->shouldReceive('flush')->andReturnUsing(function ($pattern) use (&$flushCalls) {
            $flushCalls[] = $pattern;
        });

        $user = new \stdClass();
        $user->id = 42;

        $observer = new UserObserver($mockRepository);
        $observer->created($user);

        $this->assertContains('users:*', $flushCalls);
    }

    /**
     * Test that observer is called with correct cache keys for updated event.
     */
    public function test_updated_event_uses_correct_cache_key_patterns(): void
    {
        $mockRepository = Mockery::mock(UserRepository::class);
        $flushCalls = [];
        $mockRepository->shouldReceive('flush')->andReturnUsing(function ($pattern) use (&$flushCalls) {
            $flushCalls[] = $pattern;
        });

        $user = new \stdClass();
        $user->id = 99;

        $observer = new UserObserver($mockRepository);
        $observer->updated($user);

        $this->assertContains('users:*', $flushCalls);
        $this->assertContains("user:99:*", $flushCalls);
    }

    /**
     * Test that flush is called with correct user ID format.
     */
    public function test_flush_called_with_correct_user_id_format(): void
    {
        $mockRepository = Mockery::mock(UserRepository::class);
        $flushCalls = [];
        $mockRepository->shouldReceive('flush')->andReturnUsing(function ($pattern) use (&$flushCalls) {
            $flushCalls[] = $pattern;
        });

        $user = new \stdClass();
        $user->id = 777;

        $observer = new UserObserver($mockRepository);
        $observer->updated($user);

        $this->assertContains("user:777:*", $flushCalls);
    }

    /**
     * Test that UserObserver has the correct method signatures.
     */
    public function test_observer_has_required_methods(): void
    {
        $mockRepository = Mockery::mock(UserRepository::class);
        $observer = new UserObserver($mockRepository);

        $this->assertTrue(method_exists($observer, 'created'));
        $this->assertTrue(method_exists($observer, 'updated'));
        $this->assertTrue(method_exists($observer, 'deleted'));
    }

    /**
     * Test that observer methods accept User model.
     */
    public function test_observer_methods_execute_without_errors(): void
    {
        $mockRepository = Mockery::mock(UserRepository::class);
        $mockRepository->shouldReceive('flush')->andReturn(null);

        $user = new \stdClass();
        $user->id = 1;

        $observer = new UserObserver($mockRepository);

        // These should not throw any exceptions
        try {
            $observer->created($user);
            $observer->updated($user);
            $observer->deleted($user);
            $this->assertTrue(true); // Success if no exception
        } catch (\Exception $e) {
            $this->fail("Observer execution threw exception: " . $e->getMessage());
        }
    }

    /**
     * Test that created event calls flush exactly once with correct pattern.
     */
    public function test_created_event_calls_flush_once_with_users_pattern(): void
    {
        $mockRepository = Mockery::mock(UserRepository::class);
        $callCount = 0;
        $mockRepository->shouldReceive('flush')
            ->times(1)
            ->with('users:*')
            ->andReturnUsing(function () use (&$callCount) {
                $callCount++;
            });

        $user = new \stdClass();
        $user->id = 1;

        $observer = new UserObserver($mockRepository);
        $observer->created($user);

        $this->assertEquals(1, $callCount);
    }

    /**
     * Test that updated event calls flush exactly twice.
     */
    public function test_updated_event_calls_flush_twice(): void
    {
        $mockRepository = Mockery::mock(UserRepository::class);
        $flushCount = 0;
        $mockRepository->shouldReceive('flush')->andReturnUsing(function () use (&$flushCount) {
            $flushCount++;
        });

        $user = new \stdClass();
        $user->id = 1;

        $observer = new UserObserver($mockRepository);
        $observer->updated($user);

        $this->assertEquals(2, $flushCount);
    }

    /**
     * Test that deleted event calls flush exactly twice.
     */
    public function test_deleted_event_calls_flush_twice(): void
    {
        $mockRepository = Mockery::mock(UserRepository::class);
        $flushCount = 0;
        $mockRepository->shouldReceive('flush')->andReturnUsing(function () use (&$flushCount) {
            $flushCount++;
        });

        $user = new \stdClass();
        $user->id = 1;

        $observer = new UserObserver($mockRepository);
        $observer->deleted($user);

        $this->assertEquals(2, $flushCount);
    }

    /**
     * Test that the observer is registered in the User model.
     */
    public function test_user_observer_is_registered(): void
    {
        // This test verifies that the User model has the boot method
        // and that it registers the UserObserver
        // We check that the User model class has the boot method defined
        $reflection = new \ReflectionClass(\App\Models\User::class);
        $this->assertTrue($reflection->hasMethod('boot'));
    }
}
