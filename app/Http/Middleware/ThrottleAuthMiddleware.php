<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ThrottleAuthMiddleware
{
    /**
     * Maximum failed login attempts allowed within the window.
     */
    const MAX_ATTEMPTS = 5;

    /**
     * Time window for tracking attempts (in seconds).
     */
    const ATTEMPT_WINDOW = 60;

    /**
     * Lockout duration after exceeding max attempts (in seconds).
     */
    const LOCKOUT_DURATION = 60;

    /**
     * Handle an incoming request.
     *
     * Track failed login attempts by IP address. Lock IP after 5 failures in 1 minute.
     * Return 429 Too Many Requests if locked out.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get client IP address
        $ip = $request->ip();

        // Build cache keys
        $attemptsKey = "auth_attempts_{$ip}";
        $lockoutKey = "auth_lockout_{$ip}";

        // Check if IP is currently locked out
        if (Cache::has($lockoutKey)) {
            return response()->json(
                ['message' => 'Too many login attempts'],
                429
            );
        }

        // Get current attempt count
        $attempts = Cache::get($attemptsKey, 0);

        // If attempts exceed max, lock the IP
        if ($attempts >= self::MAX_ATTEMPTS) {
            Cache::put($lockoutKey, true, self::LOCKOUT_DURATION);

            return response()->json(
                ['message' => 'Too many login attempts'],
                429
            );
        }

        // Let the request continue
        $response = $next($request);

        // If request was successful (not a failed login), don't increment attempts
        // Note: This middleware assumes that failed logins will trigger a 422 or similar response
        // The controller will handle clearing attempts on successful login

        return $response;
    }

    /**
     * Increment the failed login attempt counter for an IP address.
     * Called by AuthController after failed login attempt.
     *
     * @param  string  $ip
     * @return void
     */
    public static function recordFailedAttempt($ip)
    {
        $attemptsKey = "auth_attempts_{$ip}";
        $attempts = Cache::get($attemptsKey, 0);
        Cache::put($attemptsKey, $attempts + 1, self::ATTEMPT_WINDOW);
    }

    /**
     * Clear the failed login attempt counter for an IP address.
     * Called by AuthController after successful login.
     *
     * @param  string  $ip
     * @return void
     */
    public static function clearAttempts($ip)
    {
        $attemptsKey = "auth_attempts_{$ip}";
        $lockoutKey = "auth_lockout_{$ip}";
        Cache::forget($attemptsKey);
        Cache::forget($lockoutKey);
    }
}
