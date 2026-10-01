<?php

use App\Models\User;

it('returns the authenticated users default preferences with the exact resource shape', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->getJson("/api/users/{$user->id}/preferences")
        ->assertOk()
        ->assertHeader('Content-Type', 'application/json')
        ->assertExactJson([
            'id' => $user->id,
            'timezone' => 'UTC',
            'email_notifications' => true,
            'marketing_notifications' => false,
        ]);
});

it('requires authentication for preference endpoints', function () {
    $user = User::factory()->create();

    $this->getJson("/api/users/{$user->id}/preferences")->assertUnauthorized();
    $this->patchJson("/api/users/{$user->id}/preferences", [
        'timezone' => 'Africa/Cairo',
    ])->assertUnauthorized();
});

it('only allows the owner to read or update preferences', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $this->actingAs($user)->getJson("/api/users/{$otherUser->id}/preferences")
        ->assertNotFound();
    $this->actingAs($user)->patchJson("/api/users/{$otherUser->id}/preferences", [
        'timezone' => 'Africa/Cairo',
    ])->assertNotFound();
});

it('validates supplied and unknown preference fields without changing data', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->patchJson("/api/users/{$user->id}/preferences", [
        'email_notifications' => 'sometimes',
    ])->assertUnprocessable()
        ->assertJsonValidationErrors(['email_notifications']);

    $this->actingAs($user)->patchJson("/api/users/{$user->id}/preferences", [
        'unknown' => 'value',
    ])->assertUnprocessable()
        ->assertJsonValidationErrors(['preferences']);

    expect($user->fresh()->timezone)->toBe('UTC')
        ->and($user->activityEvents()->count())->toBe(0);
});

it('updates preferences, persists them, and records a safe activity event', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->patchJson("/api/users/{$user->id}/preferences", [
        'timezone' => 'Africa/Cairo',
        'email_notifications' => false,
        'marketing_notifications' => true,
    ]);

    $response->assertOk()->assertExactJson([
        'id' => $user->id,
        'timezone' => 'Africa/Cairo',
        'email_notifications' => false,
        'marketing_notifications' => true,
    ]);

    expect($user->fresh()->only([
        'timezone',
        'email_notifications',
        'marketing_notifications',
    ]))->toBe([
        'timezone' => 'Africa/Cairo',
        'email_notifications' => false,
        'marketing_notifications' => true,
    ]);

    $event = $user->activityEvents()->sole();

    expect($event->event)->toBe('preferences.updated')
        ->and($event->metadata)->toBeNull()
        ->and($event->toArray())->not->toHaveKey('password')
        ->and($event->toArray())->not->toHaveKey('token');
});
