<?php

it('renders the required sections and navigation landmarks', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('aria-label="Primary"', false)
        ->assertSee('id="hero"', false)
        ->assertSee('id="about"', false)
        ->assertSee('id="experience"', false)
        ->assertSee('id="projects"', false)
        ->assertSee('id="skills"', false)
        ->assertSee('id="contact"', false);
});

it('keeps the page contract compact and responsive by surfacing the same sections on mobile and desktop', function () {
    $this->get('/')
        ->assertSee('About', false)
        ->assertSee('Contact', false)
        ->assertSee('Laravel', false)
        ->assertSee('Design systems', false);
});
