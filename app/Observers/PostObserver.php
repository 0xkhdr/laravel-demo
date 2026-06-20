<?php

namespace App\Observers;

use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Log;

/**
 * PostObserver
 *
 * Listens to Post model events and invalidates relevant caches.
 * - On created: invalidate posts:* cache (list cache)
 * - On updated: invalidate posts:* and post:{id}:* caches
 * - On deleted: invalidate posts:* and post:{id}:* caches
 */
class PostObserver
{
    protected PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Handle the Post "created" event.
     *
     * When a new post is created, invalidate the posts list cache to ensure
     * the next query will include the new post.
     *
     * @param mixed $post
     * @return void
     */
    public function created(mixed $post): void
    {
        // Invalidate all post list caches
        $this->postRepository->flush('posts:*');

        try {
            Log::info("Cache invalidated for new post created", [
                'post_id' => $post->id,
                'pattern' => 'posts:*'
            ]);
        } catch (\Exception $e) {
            // Logging might not be available in all contexts
        }
    }

    /**
     * Handle the Post "updated" event.
     *
     * When a post is updated, invalidate both the list cache (in case filters changed)
     * and the single post cache for this specific post.
     *
     * @param mixed $post
     * @return void
     */
    public function updated(mixed $post): void
    {
        // Invalidate all post list caches
        $this->postRepository->flush('posts:*');

        // Invalidate specific post cache and related caches
        $this->postRepository->flush("post:{$post->id}:*");

        try {
            Log::info("Cache invalidated for post update", [
                'post_id' => $post->id,
                'patterns' => ['posts:*', "post:{$post->id}:*"]
            ]);
        } catch (\Exception $e) {
            // Logging might not be available in all contexts
        }
    }

    /**
     * Handle the Post "deleted" event.
     *
     * When a post is deleted, invalidate both the list cache and the specific
     * post cache to ensure deleted posts don't appear in future queries.
     *
     * @param mixed $post
     * @return void
     */
    public function deleted(mixed $post): void
    {
        // Invalidate all post list caches
        $this->postRepository->flush('posts:*');

        // Invalidate specific post cache and related caches
        $this->postRepository->flush("post:{$post->id}:*");

        try {
            Log::info("Cache invalidated for post deletion", [
                'post_id' => $post->id,
                'patterns' => ['posts:*', "post:{$post->id}:*"]
            ]);
        } catch (\Exception $e) {
            // Logging might not be available in all contexts
        }
    }
}
