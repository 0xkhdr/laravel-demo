<?php

use Database\Seeders\ArticleSeeder;

it('renders Nothing.tech layout hooks on the public homepage', function () {
    $this->seed(ArticleSeeder::class);

    $this->get('/')
        ->assertOk()
        ->assertSee('class="hero', false)
        ->assertSee('class="section-header', false)
        ->assertSee('class="article-card', false)
        ->assertSee('class="site-footer', false)
        ->assertSee('Skip to content');
});

it('ships monochrome tokens and reduced motion behavior in the assets', function () {
    $css = file_get_contents(resource_path('css/app.css'));
    $js = file_get_contents(resource_path('js/app.js'));

    expect($css)->toContain('--color-bg')
        ->and($css)->toContain('--color-bg-alt')
        ->and($css)->toContain('--color-text-primary')
        ->and($css)->toContain('outline: 2px solid var(--color-accent)')
        ->and($css)->toContain('@media (prefers-reduced-motion: reduce)')
        ->and($js)->toContain('prefers-reduced-motion')
        ->and($js)->toContain('IntersectionObserver')
        ->and($js)->toContain('dataset.motion');
});
