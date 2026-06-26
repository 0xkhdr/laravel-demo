<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Designing reliable APIs for growing Laravel teams',
                'slug' => 'designing-reliable-apis-for-growing-laravel-teams',
                'excerpt' => 'Practical guardrails that keep public JSON predictable as a codebase expands.',
                'body' => <<<'HTML'
Good APIs stay boring in the best possible way: predictable payloads, clear naming, and stable contracts.

In Laravel, that usually means thin controllers, focused resources, and strict control over what leaves the application boundary.
HTML,
                'is_published' => true,
                'published_at' => now()->subWeeks(3),
            ],
            [
                'title' => 'What I look for in backend code reviews',
                'slug' => 'what-i-look-for-in-backend-code-reviews',
                'excerpt' => 'A checklist for finding risk without turning review into gatekeeping.',
                'body' => <<<'HTML'
The best reviews improve correctness, maintainability, and team confidence at the same time.

I look for naming clarity, boundary leaks, query shape, and whether the code can survive the next feature without turning into a puzzle.
HTML,
                'is_published' => true,
                'published_at' => now()->subWeek(),
            ],
            [
                'title' => 'Keeping Laravel deployments calm under pressure',
                'slug' => 'keeping-laravel-deployments-calm-under-pressure',
                'excerpt' => 'A few habits that make release day feel routine instead of risky.',
                'body' => <<<'HTML'
Operational calm comes from repeatable steps: small diffs, test coverage, observable behavior, and fast rollback options.

The goal is not zero change. The goal is change that is easy to trust.
HTML,
                'is_published' => true,
                'published_at' => now()->subDay(),
            ],
        ];

        foreach ($articles as $article) {
            Article::query()->updateOrCreate(
                ['slug' => $article['slug']],
                $article,
            );
        }
    }
}
