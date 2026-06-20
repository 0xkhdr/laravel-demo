<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LogoutUser
{
    /**
     * Log out a user and revoke all their Sanctum tokens.
     *
     * @param User $user
     * @return void
     */
    public function __invoke(User $user): void
    {
        // Revoke all Sanctum tokens for this user
        $user->tokens()->delete();

        // Log out the user from session
        Auth::logout();
    }
}
