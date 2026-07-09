<?php

it('renders the Nothing portfolio landing page', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('Nothing Portfolio', false)
        ->assertSee('Building precise interfaces with a quiet, technical edge.', false)
        ->assertSee('View selected work', false)
        ->assertSee('Signal Interface', false)
        ->assertSee('Email', false);
});

it('sources the page copy from the shared portfolio config', function () {
    $this->get('/')
        ->assertSee('A portfolio built like a tool, not a brochure.', false)
        ->assertSee('Independent / Consulting', false)
        ->assertSee('linkedin.com/in/nothingportfolio', false);
});
