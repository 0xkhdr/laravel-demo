<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\ChangePasswordRequest;
use App\Support\AuditLogger;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show the user's profile page.
     * Display name, email, verification status, last login.
     * Auth required.
     */
    public function show()
    {
        $user = Auth::user();

        return view('auth.profile.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the change password form.
     * Auth required.
     */
    public function showChangePasswordForm()
    {
        return view('auth.profile.change-password');
    }

    /**
     * Handle password change.
     * Verify current password, hash and update password, keep session alive, log audit, redirect.
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();

        // Validate and update password
        $user->update([
            'password' => Hash::make($request->validated('password')),
        ]);

        // Log the password change event
        AuditLogger::passwordChange($user, $request->ip());

        // Keep session alive - no session regeneration to maintain current session
        // (Unlike password reset, we don't revoke all sessions)

        return redirect()->route('profile.show')
            ->with('success', 'Password changed successfully.');
    }
}
