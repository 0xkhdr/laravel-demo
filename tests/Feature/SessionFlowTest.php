<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SessionFlowTest extends TestCase
{
	use RefreshDatabase;

	public function test_authenticated_user_can_logout()
	{
		$user = User::create([
			'name' => 'John Doe',
			'email' => 'john@example.com',
			'password' => bcrypt('SecurePassword123!'),
			'email_verified_at' => now(),
		]);

		$this->actingAs($user);
		$this->assertAuthenticatedAs($user);

		$response = $this->post(route('logout'));

		$response->assertRedirect(route('auth.login'));
		$this->assertGuest();
	}

	public function test_session_destroyed_after_logout()
	{
		$user = User::create([
			'name' => 'John Doe',
			'email' => 'john@example.com',
			'password' => bcrypt('SecurePassword123!'),
			'email_verified_at' => now(),
		]);

		$this->actingAs($user);
		$this->post(route('logout'));

		$response = $this->get(route('profile.show'));
		$response->assertRedirect(route('auth.login'));
	}

	public function test_remember_me_token_revoked_after_logout()
	{
		$user = User::create([
			'name' => 'John Doe',
			'email' => 'john@example.com',
			'password' => bcrypt('SecurePassword123!'),
			'email_verified_at' => now(),
		]);

		$this->post(route('auth.login'), [
			'email' => 'john@example.com',
			'password' => 'SecurePassword123!',
			'remember' => true,
		]);

		$this->assertAuthenticatedAs($user);

		$this->post(route('logout'));
		$this->assertGuest();
	}

	public function test_logout_without_csrf_fails()
	{
		$user = User::create([
			'name' => 'John Doe',
			'email' => 'john@example.com',
			'password' => bcrypt('SecurePassword123!'),
			'email_verified_at' => now(),
		]);

		$this->actingAs($user);

		$response = $this->post(route('logout'), [], ['X-CSRF-TOKEN' => 'invalid']);

		$response->assertStatus(419);
	}
}
