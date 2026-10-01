<?php

it('returns the application health status', function () {
    $this->getJson('/api/health')
        ->assertOk()
        ->assertExactJson([
            'status' => 'ok',
            'application' => 'laravel-demo',
        ])
        ->assertHeader('Content-Type', 'application/json');
});
