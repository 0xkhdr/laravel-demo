<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\TestCase;

class PasswordResetFlowTest extends TestCase
{
	use RefreshDatabase;

	public function test_forgot_password_with_registered_email_sends_reset_email()
	{
		Notification::fake();

		$user = User::create([
			'name' => 'John Doe',
			'email' => 'john@example.com',
			'password' => bcrypt('OldPassword123!'),
			'email_verified_at' => now(),
		]);

		$response = $this->post(route('auth.forgot-password'), [
			'email' => 'john@example.com',
		]);

        $response->assertRedirect(route('auth.login'));
		Notification::assertQueued(\App\Notifications\PasswordResetNotification::class);
		$this->assertDatabaseHas('password_reset_tokens', ['email' => 'john@example.com']);
	}

	public function test_forgot_password_with_unregistered_email_no_leak()
	{
		Notification::fake();

		$response = $this->post(route('auth.forgot-password'), [
			'email' => 'nonexistent@example.com',
		]);

        $response->assertRedirect(route('auth.login'));
		$response->assertSessionHas('status', 'If an account exists for that email, a password reset link has been sent.');
		Notification::assertNotQueued(\App\Notifications\PasswordResetNotification::class);
	}

	public function test_expired_token_shows_error()
	{
		$user = User::create([
			'name' => 'John Doe',
			'email' => 'john@example.com',
			'password' => bcrypt('OldPassword123!'),
			'email_verified_at' => now(),
		]);

		$token = Str::random(64);
		DB::table('password_reset_tokens')->insert([
			'email' => 'john@example.com',
			'token' => Hash::make($token),
			'expires_at' => now()->subHour(),
			'created_at' => now(),
		]);

		$response = $this->get(route('auth.show-reset-form', ['email' => 'john@example.com', 'token' => $token]));

		$response->assertRedirect(route('auth.login'));
		$response->assertSessionHas('error', 'This password reset link is invalid or has expired.');
	}

	public function test_token_consumed_error_on_reuse()
	{
		$user = User::create([
			'name' => 'John Doe',
			'email' => 'john@example.com',
			'password' => bcrypt('OldPassword123!'),
			'email_verified_at' => now(),
		]);

		$token = Str::random(64);
		DB::table('password_reset_tokens')->insert([
			'email' => 'john@example.com',
			'token' => Hash::make($token),
			'expires_at' => now()->addHour(),
			'created_at' => now(),
		]);

		// First reset
		$this->post(route('auth.reset-password'), [
			'email' => 'john@example.com',
			'token' => $token,
			'password' => 'NewPassword123!',
			'password_confirmation' => 'NewPassword123!',
		]);

		// Token should be consumed
		$this->assertDatabaseMissing('password_reset_tokens', ['email' => 'john@example.com']);

		// Attempt reuse
		$response = $this->get(route('auth.show-reset-form', ['email' => 'john@example.com', 'token' => $token]));
		$response->assertRedirect(route('auth.login'));
	}

	public function test_complete_password_reset_flow()
	{
		Notification::fake();

		$user = User::create([
			'name' => 'John Doe',
			'email' => 'john@example.com',
			'password' => bcrypt('OldPassword123!'),
			'email_verified_at' => now(),
		]);

		$oldPasswordHash = $user->password;

		// Request reset
		$this->post(route('auth.forgot-password'), ['email' => 'john@example.com']);

		// Get token from notification or DB
		$tokenRecord = DB::table('password_reset_tokens')
			->where('email', 'john@example.com')
			->first();

		// Extract actual token for the reset form
		$token = Str::random(64); // In real scenario, extract from email

		// Show reset form
		$formResponse = $this->get(route('auth.show-reset-form', ['email' => 'john@example.com', 'token' => $token]));

		// Reset password
		$resetResponse = $this->post(route('auth.reset-password'), [
			'email' => 'john@example.com',
			'token' => $token,
			'password' => 'NewPassword123!',
			'password_confirmation' => 'NewPassword123!',
		]);

		$resetResponse->assertRedirect(route('auth.login'));

		// Verify password changed
		$user->refresh();
		$this->assertTrue(Hash::check('NewPassword123!', $user->password));
		$this->assertNotEqual($oldPasswordHash, $user->password);

		// Verify old password doesn't work
		$loginOldResponse = $this->post(route('auth.login'), [
			'email' => 'john@example.com',
			'password' => 'OldPassword123!',
		]);
		$loginOldResponse->assertRedirect();

		// Verify new password works
		$loginNewResponse = $this->post(route('auth.login'), [
			'email' => 'john@example.com',
			'password' => 'NewPassword123!',
		]);
		$this->assertAuthenticatedAs($user);
	}
}
