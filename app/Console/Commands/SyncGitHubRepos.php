<?php

namespace App\Console\Commands;

use App\Models\GitHubRepo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncGitHubRepos extends Command
{
    protected $signature = 'sync:repos';
    protected $description = 'Sync GitHub repositories for the configured user';

    public function handle()
    {
        $username = config('services.github.username');
        $token = config('services.github.token');

        if (!$username || !$token) {
            Log::warning('GitHub sync: missing username or token configuration');
            return 1;
        }

        try {
            $repos = Cache::remember("github_repos:{$username}", now()->addHours(24), function () use ($username, $token) {
                $response = Http::withHeaders([
                    'Authorization' => "token {$token}",
                    'Accept' => 'application/vnd.github.v3+json',
                ])->get("https://api.github.com/users/{$username}/repos");

                if (!$response->successful()) {
                    Log::warning("GitHub API error: {$response->status()}");
                    return [];
                }

                return $response->json();
            });

            foreach ($repos as $repo) {
                GitHubRepo::updateOrCreate(
                    ['url' => $repo['html_url']],
                    [
                        'name' => $repo['name'],
                        'description' => $repo['description'],
                        'stars' => $repo['stargazers_count'],
                        'forks' => $repo['forks_count'],
                        'language' => $repo['language'],
                        'updated_at' => $repo['updated_at'],
                    ]
                );
            }

            return 0;
        } catch (\Exception $e) {
            Log::warning("GitHub sync failed: {$e->getMessage()}");
            return 1;
        }
    }
}
