<?php

use App\Models\User;

it('returns the authenticated users activity newest first', function () {
    $user = User::factory()->create();
    $user->activityEvents()->create([
        'event' => 'older',
        'created_at' => now()->subDay(),
    ]);
    $user->activityEvents()->create([
        'event' => 'newer',
        'created_at' => now(),
    ]);

    $this->actingAs($user)->getJson("/api/users/{$user->id}/activity")
        ->assertOk()
        ->assertJsonPath('data.0.event', 'newer')
        ->assertJsonPath('data.1.event', 'older')
        ->assertJsonMissing(['password'])
        ->assertJsonMissing(['token']);
});

it('returns an empty activity list for an authenticated user without events', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->getJson("/api/users/{$user->id}/activity")
        ->assertOk()
        ->assertExactJson(['data' => []]);
});

it('does not disclose another users activity', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $otherUser->activityEvents()->create(['event' => 'login']);

    $this->actingAs($user)->getJson("/api/users/{$otherUser->id}/activity")
        ->assertNotFound()
        ->assertJsonMissing(['event' => 'login']);
});

it('requires authentication to read activity', function () {
    $user = User::factory()->create();

    $this->getJson("/api/users/{$user->id}/activity")
        ->assertUnauthorized();
});
