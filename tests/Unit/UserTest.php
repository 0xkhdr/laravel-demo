<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

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

it('has the HasRoles trait', function () {
    $user = new User();

    expect(method_exists($user, 'hasRole'))->toBeTrue()
        ->and(method_exists($user, 'hasPermissionTo'))->toBeTrue()
        ->and(method_exists($user, 'assignRole'))->toBeTrue();
});

