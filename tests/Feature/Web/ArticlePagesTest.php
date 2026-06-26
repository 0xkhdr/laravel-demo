<?php

use App\Models\Article;
use Database\Seeders\ArticleSeeder;

it('lists published articles newest first', function () {
    $this->seed(ArticleSeeder::class);

    $this->get('/articles')
        ->assertOk()
        ->assertSeeInOrder([
            'Keeping Laravel deployments calm under pressure',
            'What I look for in backend code reviews',
            'Designing reliable APIs for growing Laravel teams',
        ]);
});

it('shows article details and the publish date', function () {
    $this->seed(ArticleSeeder::class);

    $article = Article::query()
        ->where('slug', 'designing-reliable-apis-for-growing-laravel-teams')
        ->firstOrFail();

    $this->get('/articles/'.$article->slug)
        ->assertOk()
        ->assertSee($article->title)
        ->assertSee($article->excerpt)
        ->assertSee('Good APIs stay boring in the best possible way', false)
        ->assertSee($article->published_at?->format('F j, Y'));
});

it('returns a 404 for a missing article', function () {
    $this->get('/articles/missing-article')->assertNotFound();
});
