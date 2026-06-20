<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Determine if the user can view a post.
     */
    public function view(?User $user, Post $post): bool
    {
        // Allow all (no auth required)
        return true;
    }

    /**
     * Determine if the user can create posts.
     */
    public function create(User $user): bool
    {
        // Allow if user has 'author' or 'editor' role
        return $user->hasRole(['author', 'editor']);
    }

    /**
     * Determine if the user can update a post.
     */
    public function update(User $user, Post $post): bool
    {
        // Allow if user owns post OR has 'editor' role
        return $user->id === $post->user_id || $user->hasRole('editor');
    }

    /**
     * Determine if the user can delete a post.
     */
    public function delete(User $user, Post $post): bool
    {
        // Allow if user owns post OR has 'admin' role
        return $user->id === $post->user_id || $user->hasRole('admin');
    }
}
