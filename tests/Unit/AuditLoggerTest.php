<?php

use App\Models\AuditLog;
use App\Support\AuditLogger;
use App\Models\User;

// Verify that AuditLog model exists and can be instantiated
it('AuditLog model exists', function () {
    expect(class_exists(AuditLog::class))->toBeTrue();
});

// Verify that AuditLog extends Model
it('AuditLog extends Illuminate Model', function () {
    $reflection = new ReflectionClass(AuditLog::class);
    expect($reflection->getParentClass()->getName())->toBe('Illuminate\Database\Eloquent\Model');
});

// Verify that AuditLog has the correct table name
it('AuditLog has audit_logs table', function () {
    $model = new AuditLog();
    expect($model->getTable())->toBe('audit_logs');
});

// Verify that AuditLog has fillable attributes
it('AuditLog has correct fillable attributes', function () {
    $model = new AuditLog();
    $fillable = $model->getFillable();
    expect($fillable)->toContain('user_id')
        ->toContain('action')
        ->toContain('ip_address')
        ->toContain('user_agent');
});

// Verify that AuditLog has a user relation
it('AuditLog has user relation', function () {
    $reflection = new ReflectionClass(AuditLog::class);
    expect($reflection->hasMethod('user'))->toBeTrue();

    $method = $reflection->getMethod('user');
    expect($method->isPublic())->toBeTrue();
});

// Verify that AuditLogger class exists
it('AuditLogger class exists', function () {
    expect(class_exists(AuditLogger::class))->toBeTrue();
});

// Verify that AuditLogger has login static method
it('AuditLogger has login static method', function () {
    $reflection = new ReflectionClass(AuditLogger::class);
    expect($reflection->hasMethod('login'))->toBeTrue();

    $method = $reflection->getMethod('login');
    expect($method->isStatic())->toBeTrue();
    expect($method->isPublic())->toBeTrue();
});

// Verify that AuditLogger has logout static method
it('AuditLogger has logout static method', function () {
    $reflection = new ReflectionClass(AuditLogger::class);
    expect($reflection->hasMethod('logout'))->toBeTrue();

    $method = $reflection->getMethod('logout');
    expect($method->isStatic())->toBeTrue();
    expect($method->isPublic())->toBeTrue();
});

// Verify that AuditLogger has passwordReset static method
it('AuditLogger has passwordReset static method', function () {
    $reflection = new ReflectionClass(AuditLogger::class);
    expect($reflection->hasMethod('passwordReset'))->toBeTrue();

    $method = $reflection->getMethod('passwordReset');
    expect($method->isStatic())->toBeTrue();
    expect($method->isPublic())->toBeTrue();
});

// Verify that AuditLogger has passwordChange static method
it('AuditLogger has passwordChange static method', function () {
    $reflection = new ReflectionClass(AuditLogger::class);
    expect($reflection->hasMethod('passwordChange'))->toBeTrue();

    $method = $reflection->getMethod('passwordChange');
    expect($method->isStatic())->toBeTrue();
    expect($method->isPublic())->toBeTrue();
});

// Verify method signatures (User parameter and string parameter)
it('login method has correct signature', function () {
    $reflection = new ReflectionClass(AuditLogger::class);
    $method = $reflection->getMethod('login');
    $params = $method->getParameters();

    expect(count($params))->toBe(2);
    expect($params[0]->getName())->toBe('user');
    expect($params[1]->getName())->toBe('ip');
});

it('logout method has correct signature', function () {
    $reflection = new ReflectionClass(AuditLogger::class);
    $method = $reflection->getMethod('logout');
    $params = $method->getParameters();

    expect(count($params))->toBe(2);
    expect($params[0]->getName())->toBe('user');
    expect($params[1]->getName())->toBe('ip');
});

it('passwordReset method has correct signature', function () {
    $reflection = new ReflectionClass(AuditLogger::class);
    $method = $reflection->getMethod('passwordReset');
    $params = $method->getParameters();

    expect(count($params))->toBe(2);
    expect($params[0]->getName())->toBe('user');
    expect($params[1]->getName())->toBe('ip');
});

it('passwordChange method has correct signature', function () {
    $reflection = new ReflectionClass(AuditLogger::class);
    $method = $reflection->getMethod('passwordChange');
    $params = $method->getParameters();

    expect(count($params))->toBe(2);
    expect($params[0]->getName())->toBe('user');
    expect($params[1]->getName())->toBe('ip');
});

// Verify that methods are callable
it('login method is callable', function () {
    expect(is_callable([AuditLogger::class, 'login']))->toBeTrue();
});

it('logout method is callable', function () {
    expect(is_callable([AuditLogger::class, 'logout']))->toBeTrue();
});

it('passwordReset method is callable', function () {
    expect(is_callable([AuditLogger::class, 'passwordReset']))->toBeTrue();
});

it('passwordChange method is callable', function () {
    expect(is_callable([AuditLogger::class, 'passwordChange']))->toBeTrue();
});
