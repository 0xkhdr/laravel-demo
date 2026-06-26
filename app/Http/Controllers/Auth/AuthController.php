<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use App\Support\AuditLogger;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle user registration.
     * Create user, hash password, dispatch verification email, redirect to verify-email.
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'password' => $request->validated('password'), // Hash facade auto-hashes due to cast
        ]);

        // Dispatch email verification notification (queued)
        $user->notify(new VerifyEmailNotification());

        return redirect()->route('verify-email')
            ->with('success', 'Registration successful. Please verify your email.');
    }

    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle user login.
     * Check email verified, validate credentials, create session, set remember-me if requested, log audit, redirect.
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $email = $credentials['email'];
        $password = $credentials['password'];

        // Find user by email
        $user = User::where('email', $email)->first();

        // Check if user exists and email is verified
        if (!$user || !$user->email_verified_at) {
            return redirect()->route('verify-email')
                ->with('error', 'Please verify your email before logging in.');
        }

        // Attempt to authenticate with the credentials
        if (!Auth::attempt(['email' => $email, 'password' => $password], $request->boolean('remember'))) {
            return back()
                ->withInput($request->safe()->except('password'))
                ->with('error', 'The provided credentials do not match our records.');
        }

        // Regenerate session to prevent fixation attacks
        $request->session()->regenerate();

        // Log the login event
        $user = Auth::user();
        AuditLogger::login($user, $request->ip());

        return redirect()->intended(route('profile.show'))
            ->with('success', 'Login successful.');
    }

    /**
     * Handle user logout.
     * Revoke session, clear cookie, log audit, redirect to login.
     */
    public function logout()
    {
        $user = Auth::user();

        if ($user) {
            // Log the logout event
            AuditLogger::logout($user, request()->ip());

            // Revoke all sessions for the user
            $user->revokeAllSessions();
        }

        // Clear the authentication session
        Auth::logout();

        // Invalidate the session
        request()->session()->invalidate();

        // Regenerate token to prevent CSRF
        request()->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Logged out successfully.');
    }
}
