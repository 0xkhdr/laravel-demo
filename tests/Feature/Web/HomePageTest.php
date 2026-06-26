<?php

use Database\Seeders\ArticleSeeder;

it('shows the owner introduction and latest articles on the homepage', function () {
    $this->seed(ArticleSeeder::class);

    $response = $this->get('/');

    $response->assertOk()
        ->assertSee('Senior Backend Engineer')
        ->assertSee('Laravel Demo')
        ->assertSee('<main', false)
        ->assertSee('<header', false)
        ->assertSeeInOrder([
            'Keeping Laravel deployments calm under pressure',
            'What I look for in backend code reviews',
            'Designing reliable APIs for growing Laravel teams',
        ]);
});
