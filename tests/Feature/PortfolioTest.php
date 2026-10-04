<?php

it('renders the career portfolio', function () {
    $this->get('/')->assertOk()
        ->assertSee('Mohamed Khedr')
        ->assertSee('Kafka + Debezium CDC')
        ->assertSee('Frontier')
        ->assertSee('PHP / Laravel')
        ->assertSee('Strong professional')
        ->assertSee('Primary backend foundation')
        ->assertSee('Reliable systems.')
        ->assertSee('WASL integration')
        ->assertSee('Connecting client and operational data')
        ->assertSee('Digital-card platform, from idea to production')
        ->assertSee('Bachelor of Commerce')
        ->assertSee('DevOps owns cluster administration')
        ->assertSee('substantially AI-assisted')
        ->assertSee('tel:+201012781205', false)
        ->assertSee('<details>', false)
        ->assertSee('Skip to content')
        ->assertDontSee('mentoring')
        ->assertSee('0xkhdr@gmail.com')
        ->assertSee('aria-controls="primary-nav"', false)
        ->assertSee('aria-label="Primary navigation"', false)
        ->assertSee('x-data="portfolioUi"', false)
        ->assertDontSee('not available yet');
});

it('presents every configured career entry, case study, project, and capability', function () {
    $response = $this->get('/')->assertOk();

    foreach (config('portfolio.experience') as $role) {
        $response->assertSee($role['company'])->assertSee($role['period'])->assertSee($role['text']);
    }

    foreach (config('portfolio.work') as $work) {
        $response->assertSee($work['title'])->assertSee($work['ownership'])->assertSee($work['detail'])->assertSee($work['outcome']);
    }

    foreach (config('portfolio.projects') as $project) {
        $response->assertSee($project['name'])->assertSee($project['evidence'])->assertSee($project['url']);
    }

    foreach (config('portfolio.skills') as $skill) {
        $response->assertSee($skill['name'])->assertSee($skill['level'])->assertSee($skill['description']);
    }
});
