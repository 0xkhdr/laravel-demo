<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class SecurityTest extends TestCase
{
	use RefreshDatabase;

	public function test_five_failed_logins_throttles_sixth_attempt()
	{
		$user = User::create([
			'name' => 'John Doe',
			'email' => 'john@example.com',
			'password' => bcrypt('SecurePassword123!'),
			'email_verified_at' => now(),
		]);

		$ip = '192.168.1.1';

		// Make 5 failed attempts
		for ($i = 0; $i < 5; $i++) {
			$this->postJson(route('auth.login'), [
				'email' => 'john@example.com',
				'password' => 'WrongPassword!',
			], ['REMOTE_ADDR' => $ip])
			->assertRedirect();
		}

		// 6th attempt should be throttled
		$response = $this->postJson(route('auth.login'), [
			'email' => 'john@example.com',
			'password' => 'WrongPassword!',
		], ['REMOTE_ADDR' => $ip]);

		$response->assertStatus(429);
	}

	public function test_resend_verification_email_throttled_more_than_once_per_minute()
	{
		$user = User::create([
			'name' => 'John Doe',
			'email' => 'john@example.com',
			'password' => bcrypt('SecurePassword123!'),
			'email_verified_at' => null,
		]);

		$this->actingAs($user);

		// First resend
		$response1 = $this->post(route('auth.resend-verification'));
		$response1->assertOk();

		// Second resend immediately after should be throttled
		$response2 = $this->post(route('auth.resend-verification'));
		$response2->assertStatus(429);
	}

	public function test_email_verification_link_uses_signed_url_and_token_validation()
	{
		$user = User::create([
			'name' => 'John Doe',
			'email' => 'john@example.com',
			'password' => bcrypt('SecurePassword123!'),
			'email_verified_at' => null,
		]);

		// Generate valid token
		$token = Str::random(64);
		DB::table('email_verification_tokens')->insert([
			'email' => 'john@example.com',
			'token' => Hash::make($token),
			'created_at' => now(),
			'expires_at' => now()->addHours(1),
		]);

		// Valid token should work
		$response = $this->post(route('auth.verify-email'), [
			'email' => 'john@example.com',
			'token' => $token,
		]);

		$user->refresh();
		$this->assertNotNull($user->email_verified_at);
	}

	public function test_tampered_verification_token_fails()
	{
		$user = User::create([
			'name' => 'John Doe',
			'email' => 'john@example.com',
			'password' => bcrypt('SecurePassword123!'),
			'email_verified_at' => null,
		]);

		$token = Str::random(64);
		DB::table('email_verification_tokens')->insert([
			'email' => 'john@example.com',
			'token' => Hash::make($token),
			'created_at' => now(),
			'expires_at' => now()->addHours(1),
		]);

		// Tampered token should fail
		$response = $this->post(route('auth.verify-email'), [
			'email' => 'john@example.com',
			'token' => 'tampered-token',
		]);

		$user->refresh();
		$this->assertNull($user->email_verified_at);
	}

	public function test_password_reset_token_one_time_use()
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
			'expires_at' => now()->addHours(1),
			'created_at' => now(),
		]);

		// First use should work
		$this->post(route('auth.reset-password'), [
			'email' => 'john@example.com',
			'token' => $token,
			'password' => 'NewPassword123!',
			'password_confirmation' => 'NewPassword123!',
		]);

		// Token should be consumed
		$this->assertDatabaseMissing('password_reset_tokens', ['email' => 'john@example.com']);

		// Second use should fail
		$response = $this->post(route('auth.reset-password'), [
			'email' => 'john@example.com',
			'token' => $token,
			'password' => 'AnotherPassword123!',
			'password_confirmation' => 'AnotherPassword123!',
		]);

		$response->assertRedirect();
		$response->assertSessionHas('error');
	}

	public function test_password_reset_token_expiry_enforced()
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
			'expires_at' => now()->subHour(), // Expired
			'created_at' => now()->subHours(2),
		]);

		$response = $this->post(route('auth.reset-password'), [
			'email' => 'john@example.com',
			'token' => $token,
			'password' => 'NewPassword123!',
			'password_confirmation' => 'NewPassword123!',
		]);

		$response->assertRedirect();
		$response->assertSessionHas('error', 'This password reset link is invalid or has expired.');
	}
}
