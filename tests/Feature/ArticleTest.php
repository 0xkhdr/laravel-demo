<?php

use App\Models\Article;
use Database\Seeders\ArticleSeeder;
it('creates article records with the expected attributes', function () {
    $article = Article::factory()->make();

    expect($article->title)->toBeString()
        ->and($article->slug)->toBeString()->not()->toBeEmpty()
        ->and($article->excerpt)->toBeString()
        ->and($article->body)->toBeString()
        ->and($article->is_published)->toBeBool();
});

it('returns published articles newest first', function () {
    $older = Article::factory()->create([
        'slug' => 'older-article',
        'published_at' => now()->subDay(),
    ]);

    $newer = Article::factory()->create([
        'slug' => 'newer-article',
        'published_at' => now(),
    ]);

    $slugs = Article::latestPublished()->pluck('slug')->all();

    expect($slugs)->toBe([$newer->slug, $older->slug]);
});

it('uses slug as the route key and seeds published content', function () {
    $this->seed(ArticleSeeder::class);

    expect((new Article)->getRouteKeyName())->toBe('slug')
        ->and(Article::published()->count())->toBeGreaterThanOrEqual(3)
        ->and(config('portfolio.owner.title'))->toBe('Senior Backend Engineer')
        ->and(config('portfolio.owner.name'))->toBe('Laravel Demo');
});
