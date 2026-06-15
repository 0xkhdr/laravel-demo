<?php

use App\Models\Project;
use App\Services\ProjectLoader;

it('successfully loads the portfolio homepage', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});

it('displays seeded projects on the portfolio page when database is connected', function () {
    // Ensure we have at least one test project in database
    Project::query()->delete();
    Project::create([
        'title' => 'TESTING BACKEND COMPONENT',
        'description' => 'This is a test description for the verification suite.',
        'technologies' => ['PHPUnit', 'Pest'],
    ]);

    $response = $this->get('/');

    $response->assertStatus(200)
        ->assertSee('TESTING BACKEND COMPONENT')
        ->assertSee('This is a test description for the verification suite.');
});

it('falls back to projects from JSON file when database connection fails', function () {
    $originalDefault = config('database.default');

    // Force a database connection exception on a broken sqlite connection
    config(['database.default' => 'broken']);
    config(['database.connections.broken' => [
        'driver' => 'sqlite',
        'database' => 'non_existent_file.sqlite',
    ]]);

    try {
        // Trigger home page route
        $response = $this->get('/');
    } finally {
        // Restore original default connection so that test teardown transaction works
        config(['database.default' => $originalDefault]);
    }

    // Assert it loads successfully and renders the project from the JSON file
    $response->assertStatus(200)
        ->assertSee('specd')
        ->assertDontSee('specd (Config Fallback)');
});

it('falls back to config fallback projects when database connection fails and JSON loading fails', function () {
    $originalDefault = config('database.default');

    // Force a database connection exception on a broken sqlite connection
    config(['database.default' => 'broken']);
    config(['database.connections.broken' => [
        'driver' => 'sqlite',
        'database' => 'non_existent_file.sqlite',
    ]]);

    // Mock ProjectLoader to throw an exception (simulating missing/corrupt JSON)
    $this->mock(ProjectLoader::class, function ($mock) {
        $mock->shouldReceive('loadProjects')->andThrow(new RuntimeException('JSON file missing or corrupt'));
    });

    try {
        // Trigger home page route
        $response = $this->get('/');
    } finally {
        // Restore original default connection so that test teardown transaction works
        config(['database.default' => $originalDefault]);
    }

    // Assert it falls back to the config fallback project
    $response->assertStatus(200)
        ->assertSee('specd (Config Fallback)');
});
