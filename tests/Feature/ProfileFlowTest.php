<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileFlowTest extends TestCase
{
	use RefreshDatabase;

	public function test_authenticated_user_views_profile()
	{
		$user = User::create([
			'name' => 'John Doe',
			'email' => 'john@example.com',
			'password' => bcrypt('SecurePassword123!'),
			'email_verified_at' => now(),
		]);

		$response = $this->actingAs($user)->get(route('profile.show'));

		$response->assertOk();
		$response->assertSee('John Doe');
		$response->assertSee('john@example.com');
	}

	public function test_change_password_with_correct_current_password()
	{
		$user = User::create([
			'name' => 'John Doe',
			'email' => 'john@example.com',
			'password' => bcrypt('OldPassword123!'),
			'email_verified_at' => now(),
		]);

		$response = $this->actingAs($user)->post(route('auth.update-password'), [
			'current_password' => 'OldPassword123!',
			'password' => 'NewPassword123!',
			'password_confirmation' => 'NewPassword123!',
		]);

		$response->assertRedirect(route('profile.show'));
		$response->assertSessionHas('status');

		$user->refresh();
		$this->assertTrue(Hash::check('NewPassword123!', $user->password));
	}

	public function test_change_password_keeps_session_alive()
	{
		$user = User::create([
			'name' => 'John Doe',
			'email' => 'john@example.com',
			'password' => bcrypt('OldPassword123!'),
			'email_verified_at' => now(),
		]);

		$this->actingAs($user);

		$response = $this->post(route('auth.update-password'), [
			'current_password' => 'OldPassword123!',
			'password' => 'NewPassword123!',
			'password_confirmation' => 'NewPassword123!',
		]);

		$this->assertAuthenticatedAs($user);
	}

	public function test_change_password_with_wrong_current_password()
	{
		$user = User::create([
			'name' => 'John Doe',
			'email' => 'john@example.com',
			'password' => bcrypt('OldPassword123!'),
			'email_verified_at' => now(),
		]);

		$response = $this->actingAs($user)->post(route('auth.update-password'), [
			'current_password' => 'WrongPassword123!',
			'password' => 'NewPassword123!',
			'password_confirmation' => 'NewPassword123!',
		]);

		$response->assertSessionHasErrors('current_password');
	}

	public function test_unauthenticated_user_redirects_to_login()
	{
		$response = $this->get(route('profile.show'));

		$response->assertRedirect(route('auth.login'));
	}
}
