<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Http\Middleware\GuestMiddleware;
use App\Http\Middleware\ThrottleAuthMiddleware;

class MiddlewareTest extends TestCase
{
    /**
     * Test that GuestMiddleware exists and is importable
     */
    public function test_guest_middleware_exists()
    {
        $this->assertTrue(class_exists('App\Http\Middleware\GuestMiddleware'));
    }

    /**
     * Test that ThrottleAuthMiddleware exists and is importable
     */
    public function test_throttle_auth_middleware_exists()
    {
        $this->assertTrue(class_exists('App\Http\Middleware\ThrottleAuthMiddleware'));
    }

    /**
     * Test that GuestMiddleware can be instantiated
     */
    public function test_guest_middleware_can_be_instantiated()
    {
        $middleware = new GuestMiddleware();
        $this->assertInstanceOf('App\Http\Middleware\GuestMiddleware', $middleware);
    }

    /**
     * Test that ThrottleAuthMiddleware can be instantiated
     */
    public function test_throttle_auth_middleware_can_be_instantiated()
    {
        $middleware = new ThrottleAuthMiddleware();
        $this->assertInstanceOf('App\Http\Middleware\ThrottleAuthMiddleware', $middleware);
    }

    /**
     * Test that GuestMiddleware has a handle method
     */
    public function test_guest_middleware_has_handle_method()
    {
        $middleware = new GuestMiddleware();
        $this->assertTrue(method_exists($middleware, 'handle'));
    }

    /**
     * Test that ThrottleAuthMiddleware has a handle method
     */
    public function test_throttle_auth_middleware_has_handle_method()
    {
        $middleware = new ThrottleAuthMiddleware();
        $this->assertTrue(method_exists($middleware, 'handle'));
    }

    /**
     * Test that ThrottleAuthMiddleware has recordFailedAttempt static method
     */
    public function test_throttle_auth_middleware_has_record_failed_attempt_method()
    {
        $this->assertTrue(method_exists('App\Http\Middleware\ThrottleAuthMiddleware', 'recordFailedAttempt'));
    }

    /**
     * Test that ThrottleAuthMiddleware has clearAttempts static method
     */
    public function test_throttle_auth_middleware_has_clear_attempts_method()
    {
        $this->assertTrue(method_exists('App\Http\Middleware\ThrottleAuthMiddleware', 'clearAttempts'));
    }

    /**
     * Test that GuestMiddleware allows unauthenticated users
     */
    public function test_guest_middleware_allows_unauthenticated_users()
    {
        // Create a request without authentication
        $request = Request::create('/auth/login', 'GET');

        // Create middleware instance
        $middleware = new GuestMiddleware();

        // Create a closure that returns 'next'
        $nextCalled = false;
        $response = $middleware->handle($request, function ($req) use (&$nextCalled) {
            $nextCalled = true;
            return response('next middleware called');
        });

        // Verify next middleware was called
        $this->assertTrue($nextCalled);
        $this->assertEquals('next middleware called', $response->getContent());
    }

    /**
     * Test ThrottleAuthMiddleware recordFailedAttempt helper
     */
    public function test_throttle_auth_middleware_record_failed_attempt()
    {
        Cache::flush();

        $ip = '192.168.1.1';
        ThrottleAuthMiddleware::recordFailedAttempt($ip);

        $this->assertEquals(1, Cache::get("auth_attempts_{$ip}"));
    }

    /**
     * Test ThrottleAuthMiddleware clearAttempts helper
     */
    public function test_throttle_auth_middleware_clear_attempts()
    {
        Cache::flush();

        $ip = '192.168.1.1';
        Cache::put("auth_attempts_{$ip}", 3);
        Cache::put("auth_lockout_{$ip}", true);

        ThrottleAuthMiddleware::clearAttempts($ip);

        $this->assertNull(Cache::get("auth_attempts_{$ip}"));
        $this->assertNull(Cache::get("auth_lockout_{$ip}"));
    }

    /**
     * Test that ThrottleAuthMiddleware returns 429 when locked out
     */
    public function test_throttle_auth_middleware_returns_429_when_locked_out()
    {
        Cache::flush();

        $ip = '192.168.1.1';
        Cache::put("auth_lockout_{$ip}", true, 60);

        $request = Request::create('/auth/login', 'POST');
        $request->server->set('REMOTE_ADDR', $ip);

        $middleware = new ThrottleAuthMiddleware();
        $response = $middleware->handle($request, function ($req) {
            return response('next middleware called');
        });

        $this->assertEquals(429, $response->getStatusCode());
    }

    /**
     * Test that ThrottleAuthMiddleware returns 429 when max attempts exceeded
     */
    public function test_throttle_auth_middleware_returns_429_when_max_attempts_exceeded()
    {
        Cache::flush();

        $ip = '192.168.1.1';
        Cache::put("auth_attempts_{$ip}", 5, 60);

        $request = Request::create('/auth/login', 'POST');
        $request->server->set('REMOTE_ADDR', $ip);

        $middleware = new ThrottleAuthMiddleware();
        $response = $middleware->handle($request, function ($req) {
            return response('next middleware called');
        });

        $this->assertEquals(429, $response->getStatusCode());
    }

    /**
     * Test that ThrottleAuthMiddleware allows request when not locked out
     */
    public function test_throttle_auth_middleware_allows_request_when_not_locked_out()
    {
        Cache::flush();

        $ip = '192.168.1.1';
        // No lockout, no attempts

        $request = Request::create('/auth/login', 'POST');
        $request->server->set('REMOTE_ADDR', $ip);

        $middleware = new ThrottleAuthMiddleware();
        $nextCalled = false;
        $response = $middleware->handle($request, function ($req) use (&$nextCalled) {
            $nextCalled = true;
            return response('next middleware called');
        });

        $this->assertTrue($nextCalled);
        $this->assertEquals('next middleware called', $response->getContent());
    }
}
