<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;

// Verify that all required methods exist in the User model
it('has verifyEmail method', function () {
    $reflection = new ReflectionClass(User::class);
    expect($reflection->hasMethod('verifyEmail'))->toBeTrue();

    $method = $reflection->getMethod('verifyEmail');
    expect($method->isPublic())->toBeTrue();
});

it('has generateEmailVerificationToken method', function () {
    $reflection = new ReflectionClass(User::class);
    expect($reflection->hasMethod('generateEmailVerificationToken'))->toBeTrue();

    $method = $reflection->getMethod('generateEmailVerificationToken');
    expect($method->isPublic())->toBeTrue();
});

it('has generatePasswordResetToken method', function () {
    $reflection = new ReflectionClass(User::class);
    expect($reflection->hasMethod('generatePasswordResetToken'))->toBeTrue();

    $method = $reflection->getMethod('generatePasswordResetToken');
    expect($method->isPublic())->toBeTrue();
});

it('has revokeAllSessions method', function () {
    $reflection = new ReflectionClass(User::class);
    expect($reflection->hasMethod('revokeAllSessions'))->toBeTrue();

    $method = $reflection->getMethod('revokeAllSessions');
    expect($method->isPublic())->toBeTrue();
});

// Verify that methods can be instantiated and called (without database)
it('verifyEmail method is callable', function () {
    $user = new User();
    expect(method_exists($user, 'verifyEmail'))->toBeTrue();
    expect(is_callable([$user, 'verifyEmail']))->toBeTrue();
});

it('generateEmailVerificationToken method is callable', function () {
    $user = new User();
    expect(method_exists($user, 'generateEmailVerificationToken'))->toBeTrue();
    expect(is_callable([$user, 'generateEmailVerificationToken']))->toBeTrue();
});

it('generatePasswordResetToken method is callable', function () {
    $user = new User();
    expect(method_exists($user, 'generatePasswordResetToken'))->toBeTrue();
    expect(is_callable([$user, 'generatePasswordResetToken']))->toBeTrue();
});

it('revokeAllSessions method is callable', function () {
    $user = new User();
    expect(method_exists($user, 'revokeAllSessions'))->toBeTrue();
    expect(is_callable([$user, 'revokeAllSessions']))->toBeTrue();
});

// Verify method return types (if type hints are present)
it('verifyEmail returns User instance', function () {
    $reflection = new ReflectionClass(User::class);
    $method = $reflection->getMethod('verifyEmail');

    // Check that the method has a return type hint
    $returnType = $method->getReturnType();
    expect($returnType)->not->toBeNull();
});

// Verify that the User model has necessary imports
it('User model imports DB and Str facades', function () {
    $reflection = new ReflectionClass(User::class);
    $filename = $reflection->getFileName();
    $content = file_get_contents($filename);

    expect($content)->toContain('use Illuminate\Support\Facades\DB')
        ->and($content)->toContain('use Illuminate\Support\Str');
});

// Verify method implementations contain expected code patterns
it('generateEmailVerificationToken creates tokens in email_verification_tokens table', function () {
    $reflection = new ReflectionClass(User::class);
    $filename = $reflection->getFileName();
    $content = file_get_contents($filename);

    // Extract the method
    $methodStart = strpos($content, 'public function generateEmailVerificationToken');
    expect($methodStart)->toBeGreaterThan(0);

    $methodContent = substr($content, $methodStart, 900);
    expect($methodContent)->toContain('email_verification_tokens')
        ->and($methodContent)->toContain('defaultEmailVerificationToken')
        ->and($methodContent)->toContain('email_verification_code_placeholder');
});

it('generatePasswordResetToken creates tokens in password_reset_tokens table', function () {
    $reflection = new ReflectionClass(User::class);
    $filename = $reflection->getFileName();
    $content = file_get_contents($filename);

    // Extract the method
    $methodStart = strpos($content, 'public function generatePasswordResetToken');
    expect($methodStart)->toBeGreaterThan(0);

    $methodContent = substr($content, $methodStart, 500);
    expect($methodContent)->toContain('password_reset_tokens')
        ->and($methodContent)->toContain('Str::random');
});

it('revokeAllSessions deletes from sessions table', function () {
    $reflection = new ReflectionClass(User::class);
    $filename = $reflection->getFileName();
    $content = file_get_contents($filename);

    // Extract the method
    $methodStart = strpos($content, 'public function revokeAllSessions');
    expect($methodStart)->toBeGreaterThan(0);

    $methodContent = substr($content, $methodStart, 300);
    expect($methodContent)->toContain('sessions')
        ->and($methodContent)->toContain('delete');
});

it('uses the default email verification code placeholder in development', function () {
    $placeholder = str_pad('DEV-VERIFY-EMAIL-CODE-PLACEHOLDER', 40, '0');

    config()->set('app.env', 'local');
    config()->set('auth.email_verification_code_placeholder', $placeholder);

    DB::shouldReceive('table')
        ->once()
        ->with('email_verification_tokens')
        ->andReturnSelf();

    DB::shouldReceive('updateOrInsert')
        ->once()
        ->with(
            ['email' => 'dev@example.com'],
            \Mockery::on(function (array $values) use ($placeholder) {
                return $values['token'] === $placeholder
                    && isset($values['created_at'], $values['expires_at']);
            })
        )
        ->andReturnTrue();

    $user = new User(['email' => 'dev@example.com']);

    expect($user->generateEmailVerificationToken())->toBe($placeholder);
});
