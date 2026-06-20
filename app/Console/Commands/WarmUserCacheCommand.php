<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class WarmUserCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:warm:users';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Warm cache for admin users and all users paginated list';

    /**
     * The UserRepository instance.
     *
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    /**
     * Create a new command instance.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info('Starting cache warming for users...');

        try {
            // Warm admin users list
            $this->info('Warming cache for admin users...');
            $adminUsers = User::role('admin')->get();
            $adminCount = $adminUsers->count();
            $this->info("Found {$adminCount} admin users.");

            // Populate find() and findByEmail() caches for admin users
            $cachedAdmins = 0;
            foreach ($adminUsers as $user) {
                try {
                    $this->userRepository->find($user->id);
                    $this->userRepository->findByEmail($user->email);
                    $this->line("  ✓ Cached admin user #{$user->id} ({$user->email})");
                    $cachedAdmins++;
                } catch (\Exception $e) {
                    $this->warn("  ✗ Failed to cache admin user #{$user->id}: {$e->getMessage()}");
                }
            }

            // Cache all users paginated (first 5 pages)
            $this->info('Warming list cache for all users (first 5 pages, 15 per page)...');
            $cachedPages = 0;
            for ($page = 1; $page <= 5; $page++) {
                try {
                    $this->userRepository->list(15, $page);
                    $this->line("  ✓ Cached page {$page} (15 per page)");
                    $cachedPages++;
                } catch (\Exception $e) {
                    $this->warn("  ✗ Failed to cache page {$page}: {$e->getMessage()}");
                }
            }

            $this->info("Successfully warmed cache for {$cachedAdmins} admin users and {$cachedPages} pages.");
            $this->info('Cache warming for users completed.');

            return 0;
        } catch (\Exception $e) {
            $this->error("Cache warming failed: {$e->getMessage()}");
            return 1;
        }
    }
}
