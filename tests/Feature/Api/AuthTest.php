<?php

use App\Models\User;

it('logs a user in with valid credentials', function () {
    $user = User::factory()->create(['password' => 'password']);

    $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ])->assertOk()
        ->assertJsonPath('user.id', $user->id);

    $this->assertAuthenticatedAs($user);
});

it('rejects invalid credentials', function () {
    $user = User::factory()->create(['password' => 'password']);

    $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'wrong',
    ])->assertUnprocessable();

    $this->assertGuest();
});

it('logs an authenticated user out', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->postJson('/api/logout')->assertNoContent();

    $this->assertGuest();
});

it('requires authentication to log out', function () {
    $this->postJson('/api/logout')->assertUnauthorized();
});
