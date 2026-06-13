<?php

use App\Models\User;

it('has the correct fillable attributes', function () {
    expect((new User)->getFillable())->toBe(['name', 'email', 'password']);
});

it('hides password and remember_token from serialization', function () {
    expect((new User)->getHidden())->toBe(['password', 'remember_token']);
});

it('casts email_verified_at to datetime', function () {
    $casts = (new User)->getCasts();

    expect($casts)->toHaveKey('email_verified_at')
        ->and($casts['email_verified_at'])->toBe('datetime');
});

it('casts password as hashed', function () {
    $casts = (new User)->getCasts();

    expect($casts)->toHaveKey('password')
        ->and($casts['password'])->toBe('hashed');
});

it('can be instantiated via factory without persisting', function () {
    $user = User::factory()->make();

    expect($user->name)->toBeString()
        ->and($user->email)->toBeString()
        ->and($user->email)->toContain('@');
});
