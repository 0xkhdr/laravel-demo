<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Redirect authenticated users away from auth pages (register, login, forgot-password).
     * This middleware ensures that authenticated users cannot access public auth routes.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If user is authenticated, redirect to dashboard
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        // Otherwise allow request to proceed
        return $next($request);
    }
}
