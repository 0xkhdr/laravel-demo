<?php

it('renders the build-nothing portfolio', function () {
    $this->get('/')->assertOk()
        ->assertSee('Your Name')
        ->assertSee('About')
        ->assertSee('Experience')
        ->assertSee('Selected work')
        ->assertSee('Skills')
        ->assertSee('Contact')
        ->assertSee('Projects will appear here when they are available.');
});
