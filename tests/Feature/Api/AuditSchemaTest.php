<?php

use App\Models\User;
use App\Models\UserActivityEvent;

it('stores safe activity event fields for a user', function () {
    $user = User::factory()->create();

    $event = $user->activityEvents()->create([
        'event' => 'login',
        'metadata' => ['ip' => '127.0.0.1'],
    ]);

    expect($event)->toBeInstanceOf(UserActivityEvent::class)
        ->and($event->user_id)->toBe($user->id)
        ->and($event->metadata)->toBe(['ip' => '127.0.0.1']);
});

it('cascades activity events when their user is deleted', function () {
    $user = User::factory()->create();
    $user->activityEvents()->create(['event' => 'login']);

    $user->delete();

    expect(UserActivityEvent::count())->toBe(0);
});

it('does not expose credentials through activity event serialization', function () {
    $event = new UserActivityEvent([
        'event' => 'login',
        'metadata' => ['email' => 'user@example.com'],
    ]);

    expect($event->toArray())->not->toHaveKey('password')
        ->and($event->toArray())->not->toHaveKey('token');
});
