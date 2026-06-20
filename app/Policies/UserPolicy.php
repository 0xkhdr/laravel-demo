<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine if the user can view another user's profile.
     */
    public function view(?User $user, User $userModel): bool
    {
        // Allow if viewing their own profile
        if ($user && $user->id === $userModel->id) {
            return true;
        }

        // Allow public viewing (for now, any authenticated user can view)
        return $user !== null;
    }

    /**
     * Determine if the user can update a user.
     */
    public function update(User $user, User $userModel): bool
    {
        // Allow if updating their own profile
        if ($user->id === $userModel->id) {
            return true;
        }

        // Allow if user has 'editor' or 'admin' role
        return $user->hasRole(['editor', 'admin']);
    }

    /**
     * Determine if the user can delete a user.
     */
    public function delete(User $user, User $userModel): bool
    {
        // Allow only if user has 'admin' role
        return $user->hasRole('admin');
    }
}
