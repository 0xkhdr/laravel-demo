<?php

use App\Models\User;
use App\Models\UserActivityEvent;

it('records a safe event after a successful login', function () {
    $user = User::factory()->create(['password' => 'password']);

    $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ])->assertOk();

    $event = $user->activityEvents()->sole();

    expect($event->event)->toBe('login')
        ->and($event->metadata)->toBeNull()
        ->and($event->toArray())->not->toHaveKey('password')
        ->and($event->toArray())->not->toHaveKey('token');
});

it('does not record an event after a failed login', function () {
    $user = User::factory()->create(['password' => 'password']);

    $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'wrong',
    ])->assertUnprocessable();

    expect($user->activityEvents()->count())->toBe(0);
});

it('keeps only the newest 100 events for a user', function () {
    $user = User::factory()->create(['password' => 'password']);

    UserActivityEvent::withoutTimestamps(function () use ($user) {
        foreach (range(1, 100) as $number) {
            $user->activityEvents()->create([
                'event' => "old-{$number}",
                'created_at' => now()->subMinute(),
            ]);
        }
    });

    $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ])->assertOk();

    expect($user->activityEvents()->count())->toBe(100)
        ->and($user->activityEvents()->where('event', 'old-1')->exists())->toBeFalse()
        ->and($user->activityEvents()->where('event', 'login')->exists())->toBeTrue();
});
