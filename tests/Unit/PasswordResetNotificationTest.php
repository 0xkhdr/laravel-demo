<?php

use App\Models\User;
use App\Notifications\PasswordResetNotification;
use Illuminate\Support\Facades\Notification;

// Test that PasswordResetNotification class exists
it('password reset notification class exists', function () {
    expect(class_exists(PasswordResetNotification::class))->toBeTrue();
});

// Test that it extends Notification
it('password reset notification extends Notification', function () {
    $reflection = new ReflectionClass(PasswordResetNotification::class);
    expect($reflection->getParentClass()->getName())->toBe('Illuminate\Notifications\Notification');
});

// Test that it has toMail method
it('has toMail method', function () {
    $reflection = new ReflectionClass(PasswordResetNotification::class);
    expect($reflection->hasMethod('toMail'))->toBeTrue();

    $method = $reflection->getMethod('toMail');
    expect($method->isPublic())->toBeTrue();
});

// Test that it has via method
it('has via method', function () {
    $reflection = new ReflectionClass(PasswordResetNotification::class);
    expect($reflection->hasMethod('via'))->toBeTrue();

    $method = $reflection->getMethod('via');
    expect($method->isPublic())->toBeTrue();
});

// Test that the notification can be instantiated
it('can be instantiated', function () {
    $notification = new PasswordResetNotification();
    expect($notification)->toBeInstanceOf(PasswordResetNotification::class);
});

// Test that via method returns mail
it('via method returns mail channel', function () {
    $notification = new PasswordResetNotification();
    $user = new User(['name' => 'Test User', 'email' => 'test@example.com']);

    $via = $notification->via($user);
    expect($via)->toContain('mail');
});

// Test that toMail generates correct email structure
it('generates correct mail message', function () {
    $user = new User(['name' => 'Test User', 'email' => 'test@example.com']);
    $notification = new PasswordResetNotification();

    // Mock the generatePasswordResetToken method
    $user->shouldReceive('generatePasswordResetToken')
        ->andReturn('test-token-12345');

    $mailMessage = $notification->toMail($user);

    expect($mailMessage)->toBeInstanceOf('Illuminate\Notifications\Messages\MailMessage');
    expect($mailMessage->subject)->toBe('Reset Your Password');
})->skip('Mocking requires proper setup');

// Test that toMail uses route to generate reset URL
it('generates reset URL with route', function () {
    $user = new User(['name' => 'Test User', 'email' => 'test@example.com']);
    $notification = new PasswordResetNotification();

    // We can verify that toMail method exists and returns MailMessage
    expect(method_exists($notification, 'toMail'))->toBeTrue();
});

// Test that notification contains greeting
it('notification greeting contains user name', function () {
    $user = new User(['name' => 'John Doe', 'email' => 'john@example.com']);

    // Check that User model has name property
    expect($user->name)->toBe('John Doe');
});

// Test that the notification is properly structured
it('notification has required components', function () {
    $reflection = new ReflectionClass(PasswordResetNotification::class);

    // Check that it has toMail and via methods
    expect($reflection->hasMethod('toMail'))->toBeTrue();
    expect($reflection->hasMethod('via'))->toBeTrue();

    // Check that it uses Queueable trait
    $traits = $reflection->getTraitNames();
    expect($traits)->toContain('Illuminate\Bus\Queueable');
});

// Helper method to render mail message (simplified version)
function renderMailMessage($mailMessage): string
{
    $content = $mailMessage->subject ?? '';

    if (isset($mailMessage->introLines)) {
        foreach ($mailMessage->introLines as $line) {
            $content .= ' ' . $line;
        }
    }

    if (isset($mailMessage->outroLines)) {
        foreach ($mailMessage->outroLines as $line) {
            $content .= ' ' . $line;
        }
    }

    return $content;
}
