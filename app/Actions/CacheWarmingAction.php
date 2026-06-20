<?php

namespace App\Actions;

use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CacheWarmingAction
{
    /**
     * The PostRepository instance.
     *
     * @var PostRepository
     */
    protected PostRepository $postRepository;

    /**
     * The UserRepository instance.
     *
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    /**
     * Create a new action instance.
     *
     * @param PostRepository $postRepository
     * @param UserRepository $userRepository
     */
    public function __construct(PostRepository $postRepository, UserRepository $userRepository)
    {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Warm both post and user caches.
     *
     * @param bool $verbose Enable verbose output
     * @return array Results and statistics
     */
    public function execute(bool $verbose = false): array
    {
        $results = [];
        $startTime = microtime(true);

        if ($verbose) {
            echo "Starting cache warming...\n";
        }

        // Warm post caches
        $postResults = $this->warmPostCache($verbose);
        $results['posts'] = $postResults;

        // Warm user caches
        $userResults = $this->warmUserCache($verbose);
        $results['users'] = $userResults;

        $endTime = microtime(true);
        $duration = $endTime - $startTime;

        $results['statistics'] = [
            'total_posts_cached' => $postResults['total_cached'] ?? 0,
            'total_users_cached' => $userResults['total_cached'] ?? 0,
            'total_pages_cached' => ($postResults['pages_cached'] ?? 0) + ($userResults['pages_cached'] ?? 0),
            'duration_seconds' => round($duration, 3),
            'success' => $postResults['success'] && $userResults['success'],
        ];

        if ($verbose) {
            echo "Cache warming completed in {$results['statistics']['duration_seconds']}s\n";
            echo "Results: {$results['statistics']['total_posts_cached']} posts, "
                . "{$results['statistics']['total_users_cached']} users, "
                . "{$results['statistics']['total_pages_cached']} pages warmed.\n";
        }

        return $results;
    }

    /**
     * Warm post cache.
     *
     * @param bool $verbose
     * @return array
     */
    protected function warmPostCache(bool $verbose = false): array
    {
        $result = [
            'success' => true,
            'total_cached' => 0,
            'pages_cached' => 0,
            'errors' => [],
        ];

        try {
            if ($verbose) {
                echo "Warming post cache...\n";
            }

            // Get top 10 popular posts by views
            try {
                $popularPosts = DB::table('posts')
                    ->select('id')
                    ->orderByDesc('views')
                    ->limit(10)
                    ->pluck('id')
                    ->toArray();
            } catch (\Exception $e) {
                // If views column doesn't exist, fallback to created_at
                $popularPosts = DB::table('posts')
                    ->select('id')
                    ->orderByDesc('created_at')
                    ->limit(10)
                    ->pluck('id')
                    ->toArray();
            }

            // Cache popular posts
            foreach ($popularPosts as $postId) {
                try {
                    $this->postRepository->find($postId);
                    $result['total_cached']++;
                    if ($verbose) {
                        echo "  Cached post #{$postId}\n";
                    }
                } catch (\Exception $e) {
                    $result['errors'][] = "Post #{$postId}: {$e->getMessage()}";
                    $result['success'] = false;
                    if ($verbose) {
                        echo "  Failed to cache post #{$postId}: {$e->getMessage()}\n";
                    }
                }
            }

            // Cache list pages
            for ($page = 1; $page <= 3; $page++) {
                try {
                    $this->postRepository->list([], $page, 15);
                    $result['pages_cached']++;
                    if ($verbose) {
                        echo "  Cached post list page {$page}\n";
                    }
                } catch (\Exception $e) {
                    $result['errors'][] = "Post page {$page}: {$e->getMessage()}";
                    $result['success'] = false;
                    if ($verbose) {
                        echo "  Failed to cache post list page {$page}: {$e->getMessage()}\n";
                    }
                }
            }
        } catch (\Exception $e) {
            $result['success'] = false;
            $result['errors'][] = "Post warming: {$e->getMessage()}";
            if ($verbose) {
                echo "Post warming failed: {$e->getMessage()}\n";
            }
        }

        return $result;
    }

    /**
     * Warm user cache.
     *
     * @param bool $verbose
     * @return array
     */
    protected function warmUserCache(bool $verbose = false): array
    {
        $result = [
            'success' => true,
            'total_cached' => 0,
            'pages_cached' => 0,
            'errors' => [],
        ];

        try {
            if ($verbose) {
                echo "Warming user cache...\n";
            }

            // Cache admin users
            $adminUsers = \App\Models\User::role('admin')->get();
            foreach ($adminUsers as $user) {
                try {
                    $this->userRepository->find($user->id);
                    $this->userRepository->findByEmail($user->email);
                    $result['total_cached']++;
                    if ($verbose) {
                        echo "  Cached admin user #{$user->id}\n";
                    }
                } catch (\Exception $e) {
                    $result['errors'][] = "Admin user #{$user->id}: {$e->getMessage()}";
                    $result['success'] = false;
                    if ($verbose) {
                        echo "  Failed to cache admin user #{$user->id}: {$e->getMessage()}\n";
                    }
                }
            }

            // Cache user list pages
            for ($page = 1; $page <= 5; $page++) {
                try {
                    $this->userRepository->list(15, $page);
                    $result['pages_cached']++;
                    if ($verbose) {
                        echo "  Cached user list page {$page}\n";
                    }
                } catch (\Exception $e) {
                    $result['errors'][] = "User page {$page}: {$e->getMessage()}";
                    $result['success'] = false;
                    if ($verbose) {
                        echo "  Failed to cache user list page {$page}: {$e->getMessage()}\n";
                    }
                }
            }
        } catch (\Exception $e) {
            $result['success'] = false;
            $result['errors'][] = "User warming: {$e->getMessage()}";
            if ($verbose) {
                echo "User warming failed: {$e->getMessage()}\n";
            }
        }

        return $result;
    }
}
