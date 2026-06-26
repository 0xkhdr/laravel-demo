<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\VerifyEmailRequest;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VerificationController extends Controller
{
    /**
     * Show the email verification page.
     */
    public function showVerifyEmailPage()
    {
        return view('auth.verify-email');
    }

    /**
     * Verify the user's email using the token.
     * Extract email and token from request, find token in email_verification_tokens,
     * check expiry, mark user.email_verified_at, consume token, redirect to login.
     */
    public function verify(VerifyEmailRequest $request)
    {
        $email = $request->validated('email');
        $token = $request->validated('token');

        // Find the verification token record
        $tokenRecord = DB::table('email_verification_tokens')
            ->where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$tokenRecord) {
            return redirect()->route('verify-email')
                ->with('error', 'Invalid verification token.');
        }

        // Check if token has expired
        if (now()->isAfter($tokenRecord->expires_at)) {
            // Delete expired token
            DB::table('email_verification_tokens')
                ->where('email', $email)
                ->delete();

            return redirect()->route('verify-email')
                ->with('error', 'Your verification token has expired. Please request a new one.');
        }

        // Find the user and verify email
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('verify-email')
                ->with('error', 'User not found.');
        }

        // Mark email as verified
        $user->verifyEmail();

        // Delete the consumed token
        DB::table('email_verification_tokens')
            ->where('email', $email)
            ->delete();

        return redirect()->route('login')
            ->with('success', 'Email verified successfully. You can now log in.');
    }

    /**
     * Resend the verification email.
     * Rate-limit to 1/min (via middleware), generate new token, dispatch notification.
     */
    public function resend()
    {
        // Get the currently authenticated user or use email from session/request
        $email = auth()->user()?->email ?? request('email');

        if (!$email) {
            return redirect()->route('verify-email')
                ->with('error', 'Email address is required.');
        }

        // Find the user
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('verify-email')
                ->with('error', 'User not found.');
        }

        // Generate new verification token
        $user->generateEmailVerificationToken();

        // Dispatch the verification email notification
        $user->notify(new VerifyEmailNotification());

        return redirect()->route('verify-email')
            ->with('success', 'Verification email has been sent. Please check your inbox.');
    }
}
