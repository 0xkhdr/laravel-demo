<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
	use RefreshDatabase;

	public function test_register_with_valid_data_queues_email()
	{
		Notification::fake();

		$response = $this->post(route('auth.register'), [
			'name' => 'John Doe',
			'email' => 'john@example.com',
			'password' => 'SecurePassword123!',
			'password_confirmation' => 'SecurePassword123!',
		]);

		$this->assertDatabaseHas('users', ['email' => 'john@example.com']);
		Notification::assertQueued(\App\Notifications\VerifyEmailNotification::class);
	}

	public function test_register_with_invalid_data_shows_validation_errors()
	{
		$response = $this->post(route('auth.register'), [
			'name' => '',
			'email' => 'invalid-email',
			'password' => 'short',
			'password_confirmation' => 'different',
		]);

		$response->assertSessionHasErrors(['name', 'email', 'password']);
	}

	public function test_login_before_email_verified_redirects_to_verify()
	{
		$user = User::create([
			'name' => 'John Doe',
			'email' => 'john@example.com',
			'password' => bcrypt('SecurePassword123!'),
			'email_verified_at' => null,
		]);

		$response = $this->post(route('auth.login'), [
			'email' => 'john@example.com',
			'password' => 'SecurePassword123!',
		]);

		$response->assertRedirect(route('auth.verify-email'));
	}

	public function test_complete_auth_flow_register_verify_login()
	{
		Notification::fake();

		// Register
		$registerResponse = $this->post(route('auth.register'), [
			'name' => 'Jane Doe',
			'email' => 'jane@example.com',
			'password' => 'SecurePassword123!',
			'password_confirmation' => 'SecurePassword123!',
		]);

		$this->assertDatabaseHas('users', ['email' => 'jane@example.com', 'email_verified_at' => null]);

		// Verify email flow
		$verifyPageResponse = $this->get(route('auth.verify-email'));
		$verifyPageResponse->assertOk();

		// Extract token from notification
		Notification::assertQueued(\App\Notifications\VerifyEmailNotification::class, function ($notification) {
			$this->token = $notification->token;
			return true;
		});

		// Verify email
		$verifyResponse = $this->post(route('auth.verify-email'), [
			'email' => 'jane@example.com',
			'token' => $this->token ?? 'test-token',
		]);

		$user = User::where('email', 'jane@example.com')->first();
		$this->assertNotNull($user->email_verified_at);

		// Login
		$loginResponse = $this->post(route('auth.login'), [
			'email' => 'jane@example.com',
			'password' => 'SecurePassword123!',
		]);

		$this->assertAuthenticatedAs($user);
	}
}
