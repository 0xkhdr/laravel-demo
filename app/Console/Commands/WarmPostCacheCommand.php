<?php

namespace App\Console\Commands;

use App\Repositories\PostRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class WarmPostCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:warm:posts';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Warm cache for popular posts (top 10 by views/engagement)';

    /**
     * The PostRepository instance.
     *
     * @var PostRepository
     */
    protected PostRepository $postRepository;

    /**
     * Create a new command instance.
     *
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        parent::__construct();
        $this->postRepository = $postRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info('Starting cache warming for posts...');

        try {
            // Get top 10 posts by views/engagement
            // Try to order by views if column exists, otherwise use created_at
            $query = DB::table('posts')->select('id')->limit(10);

            // Try to order by views column if it exists
            try {
                $popularPosts = $query->orderByDesc('views')->pluck('id')->toArray();
            } catch (\Exception $e) {
                // If views column doesn't exist, fallback to created_at
                $this->info('Views column not found, using creation order instead.');
                $popularPosts = DB::table('posts')
                    ->select('id')
                    ->orderByDesc('created_at')
                    ->limit(10)
                    ->pluck('id')
                    ->toArray();
            }

            $count = count($popularPosts);

            if (empty($popularPosts)) {
                $this->warn('No posts found to warm cache.');
                return 0;
            }

            $this->info("Found {$count} popular posts to cache.");

            // Warm find() cache for each popular post with eager loaded relations
            $this->info('Warming find() cache for popular posts...');
            $warmedCount = 0;
            foreach ($popularPosts as $postId) {
                try {
                    $this->postRepository->find($postId);
                    $this->line("  ✓ Cached post #{$postId}");
                    $warmedCount++;
                } catch (\Exception $e) {
                    $this->warn("  ✗ Failed to cache post #{$postId}: {$e->getMessage()}");
                }
            }

            // Cache list for first 3 pages (perPage = 15)
            $this->info('Warming list cache for first 3 pages (perPage = 15)...');
            for ($page = 1; $page <= 3; $page++) {
                try {
                    $this->postRepository->list([], $page, 15);
                    $this->line("  ✓ Cached page {$page} (15 per page)");
                } catch (\Exception $e) {
                    $this->warn("  ✗ Failed to cache page {$page}: {$e->getMessage()}");
                }
            }

            $this->info("Successfully warmed cache for {$warmedCount} posts and 3 pages.");
            $this->info('Cache warming for posts completed.');

            return 0;
        } catch (\Exception $e) {
            $this->error("Cache warming failed: {$e->getMessage()}");
            return 1;
        }
    }
}
