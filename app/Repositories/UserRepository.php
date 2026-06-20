<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

/**
 * UserRepository
 *
 * Abstract cache layer for user queries. Implements caching with configurable TTLs.
 */
class UserRepository
{
    /**
     * List users with pagination and caching.
     *
     * Caches paginated users with 1-hour TTL. Uses Cache::remember() for atomic get/store.
     * Eagerly loads roles relationship.
     *
     * @param int $perPage Items per page
     * @param int $page Page number
     * @return LengthAwarePaginator
     */
    public function list(int $perPage = 15, int $page = 1): LengthAwarePaginator
    {
        // Generate cache key from page and perPage parameters
        $cacheKey = "users:{$page}:{$perPage}";

        // Get TTL from config (users.list should be 1 hour = 3600 seconds)
        $ttl = config('cache.ttl.users.list', 60 * 60);

        // Use Cache::remember() for atomic get/store
        return Cache::remember($cacheKey, $ttl, function () use ($page, $perPage) {
            // Query users with eager-loaded roles relationship
            return User::with('roles')->paginate($perPage, ['*'], 'page', $page);
        });
    }

    /**
     * Find a single user by ID with caching.
     *
     * Caches user with 1-hour TTL. Eagerly loads roles relationship.
     *
     * @param int $id User ID
     * @return ?User
     */
    public function find(int $id): ?User
    {
        $cacheKey = "user:{$id}";
        $ttl = config('cache.ttl.users.single', 60 * 60);

        // Use Cache::remember() with 1-hour TTL
        return Cache::remember($cacheKey, $ttl, function () use ($id) {
            return User::with('roles')->find($id);
        });
    }

    /**
     * Find a user by email with caching.
     *
     * Caches user with 30-minute TTL. Eagerly loads roles relationship.
     *
     * @param string $email User email address
     * @return ?User
     */
    public function findByEmail(string $email): ?User
    {
        $cacheKey = "user:email:{$email}";
        $ttl = config('cache.ttl.users.email', 30 * 60);

        // Use Cache::remember() with 30-minute TTL
        return Cache::remember($cacheKey, $ttl, function () use ($email) {
            return User::with('roles')->where('email', $email)->first();
        });
    }

    /**
     * Create a new user and invalidate list cache.
     *
     * Creates a user and flushes all user list caches to ensure consistency.
     *
     * @param array $data User data
     * @return User
     */
    public function create(array $data): User
    {
        // Create the user
        $user = User::create($data);

        // Invalidate all user list caches
        $this->flush('users:*');

        return $user;
    }

    /**
     * Update a user and invalidate relevant caches.
     *
     * Updates user data and clears caches for this user by ID and email.
     * Also invalidates all list caches since the data has changed.
     *
     * @param int $id User ID
     * @param array $data Updated user data
     * @return User
     */
    public function update(int $id, array $data): User
    {
        // Get current user to know the old email (if email is being changed)
        $user = User::find($id);

        if (!$user) {
            throw new \Exception("User not found");
        }

        // Store old email for cache invalidation
        $oldEmail = $user->email;

        // Update the user
        $user->update($data);

        // Invalidate caches
        Cache::forget("user:{$id}");
        Cache::forget("user:email:{$oldEmail}");

        // If email was changed, also invalidate new email cache
        if (isset($data['email']) && $data['email'] !== $oldEmail) {
            Cache::forget("user:email:{$data['email']}");
        }

        // Invalidate all list caches
        $this->flush('users:*');

        return $user;
    }

    /**
     * Delete a user and invalidate relevant caches.
     *
     * Deletes user and clears caches for this user by ID and email.
     * Also invalidates all list caches.
     *
     * @param int $id User ID
     * @return bool
     */
    public function delete(int $id): bool
    {
        // Get user to know the email
        $user = User::find($id);

        if (!$user) {
            return false;
        }

        // Store email for cache invalidation
        $email = $user->email;

        // Delete the user
        $deleted = $user->delete();

        if ($deleted) {
            // Invalidate caches
            Cache::forget("user:{$id}");
            Cache::forget("user:email:{$email}");

            // Invalidate all list caches
            $this->flush('users:*');
        }

        return $deleted;
    }

    /**
     * Flush cache entries by pattern.
     *
     * Supports wildcard patterns for batch invalidation.
     * Examples:
     * - 'users:*' → invalidates all user list caches
     * - 'user:*' → invalidates all user caches
     *
     * @param string $pattern Cache key pattern (e.g., 'users:*', 'user:*')
     * @return void
     */
    private function flush(string $pattern): void
    {
        try {
            $store = Cache::getStore();

            // If using Redis driver, leverage Redis pattern matching
            if (method_exists($store, 'connection')) {
                $connection = $store->connection();
                // Use Redis KEYS command to find matching patterns
                $keys = $connection->keys($pattern);
                foreach ($keys as $key) {
                    // Remove the cache key prefix if present
                    Cache::forget($key);
                }
            } else {
                // Fallback for other cache drivers: attempt direct forget
                Cache::forget($pattern);
            }

            // Log the flush operation for debugging
            \Log::debug("Cache flushed for pattern: {$pattern}");
        } catch (\Exception $e) {
            // Log errors but don't throw - graceful degradation
            \Log::warning("Failed to flush cache pattern {$pattern}: " . $e->getMessage());
        }
    }
}
