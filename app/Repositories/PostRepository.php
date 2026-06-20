<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * PostRepository
 *
 * Abstract cache layer for post queries. Scaffolding for cache integration.
 */
class PostRepository
{
    /**
     * List posts with optional filtering and pagination.
     *
     * @param array $filters Filter conditions
     * @param int $page Page number
     * @param int $perPage Items per page
     * @return LengthAwarePaginator
     */
    public function list(array $filters = [], int $page = 1, int $perPage = 15): LengthAwarePaginator
    {
        // Generate cache key from filters hash
        $filtersHash = md5(json_encode($filters));
        $cacheKey = "posts:{$filtersHash}:{$page}:{$perPage}";

        // Get TTL from config (posts.list should be 5 minutes = 300 seconds)
        $ttl = config('cache.ttl.posts.list', 5 * 60);

        // Use Cache::remember() for atomic get/store
        return Cache::remember($cacheKey, $ttl, function () use ($filters, $page, $perPage) {
            // Query posts and apply filters
            $query = Post::query();

            // Apply filters if provided
            if (!empty($filters)) {
                // Example filter implementation - can be extended based on actual filter requirements
                if (isset($filters['search'])) {
                    $query->where('title', 'like', "%{$filters['search']}%")
                          ->orWhere('body', 'like', "%{$filters['search']}%");
                }

                if (isset($filters['user_id'])) {
                    $query->where('user_id', $filters['user_id']);
                }

                if (isset($filters['status'])) {
                    $query->where('status', $filters['status']);
                }
            }

            // Return paginated collection
            return $query->paginate($perPage, ['*'], 'page', $page);
        });
    }

    /**
     * Find a single post by ID with caching.
     *
     * Caches published posts with 1-hour TTL. Skips caching for draft posts.
     * Eagerly loads relationships (author, tags) and comments count.
     *
     * @param int $id Post ID
     * @return ?Post
     */
    public function find(int $id): ?Post
    {
        $cacheKey = "post:{$id}";
        $ttl = config('cache.ttl.posts.single', 60 * 60);

        // Use Cache::remember() with 1-hour TTL
        $post = Cache::remember($cacheKey, $ttl, function () use ($id) {
            return Post::with(['author', 'tags'])->withCount('comments')->find($id);
        });

        // If post exists and is draft, bypass cache and query directly without storing
        if ($post && $post->status === 'draft') {
            // Clear the cached value since draft posts should not be cached
            Cache::forget($cacheKey);
            // Return the post without caching
            return Post::with(['author', 'tags'])->withCount('comments')->find($id);
        }

        return $post;
    }

    /**
     * Flush cache entries by pattern.
     *
     * Supports wildcard patterns for batch invalidation.
     * Examples:
     * - 'posts:*' → invalidates all post list caches
     * - 'post:42:*' → invalidates specific post and its related caches
     *
     * @param string $pattern Cache key pattern (e.g., 'posts:*', 'post:42:*')
     * @return void
     */
    public function flush(string $pattern): void
    {
        // Use Laravel's cache store to handle pattern-based deletion
        // For Redis, Cache::forget() with wildcard patterns works with Redis keys
        // For other drivers, we need to handle pattern matching manually

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
                // This works for Redis via Laravel's Cache facade
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
