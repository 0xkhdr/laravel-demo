<?php

namespace App\Observers;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Log;

/**
 * UserObserver
 *
 * Listens to User model events and invalidates relevant caches.
 * - On created: invalidate users:* cache (list cache)
 * - On updated: invalidate users:* and user:{id}:* caches
 * - On deleted: invalidate users:* and user:{id}:* caches
 */
class UserObserver
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle the User "created" event.
     *
     * When a new user is created, invalidate the users list cache to ensure
     * the next query will include the new user.
     *
     * @param mixed $user
     * @return void
     */
    public function created(mixed $user): void
    {
        $this->userRepository->flush('users:*');
        Log::info("Cache invalidated for created user", ['user_id' => $user->id]);
    }

    /**
     * Handle the User "updated" event.
     *
     * When a user is updated, invalidate both the list cache and the specific user cache
     * to ensure consistency across queries.
     *
     * @param mixed $user
     * @return void
     */
    public function updated(mixed $user): void
    {
        $this->userRepository->flush('users:*');
        $this->userRepository->flush("user:{$user->id}:*");
        Log::info("Cache invalidated for updated user", [
            'user_id' => $user->id,
            'patterns' => ['users:*', "user:{$user->id}:*"]
        ]);
    }

    /**
     * Handle the User "deleted" event.
     *
     * When a user is deleted, invalidate both the list cache and the specific user cache.
     *
     * @param mixed $user
     * @return void
     */
    public function deleted(mixed $user): void
    {
        $this->userRepository->flush('users:*');
        $this->userRepository->flush("user:{$user->id}:*");
        Log::info("Cache invalidated for deleted user", [
            'user_id' => $user->id,
            'patterns' => ['users:*', "user:{$user->id}:*"]
        ]);
    }
}
