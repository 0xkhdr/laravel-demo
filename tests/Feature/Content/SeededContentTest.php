<?php

use App\Models\Article;
use Database\Seeders\ArticleSeeder;

it('seeds sample profile content and published articles', function () {
    $this->seed(ArticleSeeder::class);

    expect(config('portfolio.owner.name'))->toBe('Laravel Demo')
        ->and(config('portfolio.owner.title'))->toBe('Senior Backend Engineer')
        ->and(config('portfolio.contact'))->toHaveCount(3)
        ->and(Article::published()->count())->toBeGreaterThanOrEqual(3);
});

it('keeps private article fields out of public api responses', function () {
    $this->seed(ArticleSeeder::class);

    $this->getJson('/api/articles')
        ->assertOk()
        ->assertJsonMissing(['is_published'])
        ->assertJsonMissing(['password']);
});
