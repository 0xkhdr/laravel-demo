<?php

use App\Models\Article;

it('returns paginated published articles without private fields', function () {
    Article::factory()->count(11)->published()->create();
    Article::factory()->unpublished()->create();

    $this->getJson('/api/articles')
        ->assertOk()
        ->assertJsonCount(10, 'data')
        ->assertJsonPath('meta.total', 11)
        ->assertJsonPath('meta.per_page', 10)
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'title', 'slug', 'excerpt', 'body', 'published_at'],
            ],
            'links' => ['first', 'last', 'prev', 'next'],
            'meta' => ['current_page', 'from', 'last_page', 'per_page', 'to', 'total'],
        ])
        ->assertJsonMissing(['is_published'])
        ->assertJsonMissing(['password']);
});

it('returns a single published article by slug', function () {
    $article = Article::factory()->create([
        'slug' => 'single-api-article',
    ]);

    $this->getJson('/api/articles/'.$article->slug)
        ->assertOk()
        ->assertJsonFragment([
            'id' => $article->id,
            'title' => $article->title,
            'slug' => $article->slug,
        ])
        ->assertJsonMissing(['is_published']);
});

it('returns 404 when an article is missing', function () {
    $this->getJson('/api/articles/missing-article')->assertNotFound();
});

it('is publicly accessible without authentication', function () {
    $this->getJson('/api/articles')->assertOk();
});
