<?php

use App\Models\Project;
use Illuminate\Support\Facades\DB;

it('successfully loads the portfolio homepage', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});

it('displays seeded projects on the portfolio page', function () {
    // Ensure we have at least one test project in database
    Project::query()->delete();
    $project = Project::create([
        'title' => 'TESTING BACKEND COMPONENT',
        'description' => 'This is a test description for the verification suite.',
        'technologies' => ['PHPUnit', 'Pest'],
    ]);

    $response = $this->get('/');
    
    $response->assertStatus(200)
        ->assertSee('TESTING BACKEND COMPONENT')
        ->assertSee('This is a test description for the verification suite.');
});

it('falls back gracefully to config projects on database exception', function () {
    // Reconfigure mysql connection to a wrong host/db to force exception
    config(['database.connections.mysql.database' => 'invalid_database_to_force_failure']);
    DB::purge('mysql');

    // Trigger home page route
    $response = $this->get('/');

    // Assert it still loads successfully with 200 and renders the config fallback project
    $response->assertStatus(200)
        ->assertSee('Nothing OS Cloud Backend (Config Fallback)');
});
