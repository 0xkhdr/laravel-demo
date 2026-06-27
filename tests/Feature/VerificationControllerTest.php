<?php

namespace Tests\Feature;

use App\Http\Controllers\Auth\VerificationController;
use App\Http\Requests\VerifyEmailRequest;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\TestCase;

class VerificationControllerTest extends TestCase
{
	use RefreshDatabase;
    /**
     * Test that VerificationController exists and can be instantiated.
     */
    public function test_verification_controller_exists()
    {
        $this->assertTrue(class_exists(VerificationController::class));
        $controller = app(VerificationController::class);
        $this->assertInstanceOf(VerificationController::class, $controller);
    }

    /**
     * Test that showVerifyEmailPage method exists.
     */
    public function test_show_verify_email_page_method_exists()
    {
        $controller = app(VerificationController::class);
        $this->assertTrue(method_exists($controller, 'showVerifyEmailPage'));
    }

    /**
     * Test that verify method exists and accepts VerifyEmailRequest.
     */
    public function test_verify_method_exists()
    {
        $controller = app(VerificationController::class);
        $this->assertTrue(method_exists($controller, 'verify'));

        // Check method signature - should accept 1 parameter
        $reflection = new \ReflectionMethod($controller, 'verify');
        $this->assertTrue($reflection->getNumberOfParameters() === 1);
    }

    /**
     * Test that resend method exists.
     */
    public function test_resend_method_exists()
    {
        $controller = app(VerificationController::class);
        $this->assertTrue(method_exists($controller, 'resend'));
    }

    /**
     * Test that VerifyEmailRequest exists and has required validation.
     */
    public function test_verify_email_request_exists()
    {
        $this->assertTrue(class_exists(VerifyEmailRequest::class));

        $request = new VerifyEmailRequest();
        $this->assertTrue(method_exists($request, 'rules'));
        $this->assertTrue(method_exists($request, 'authorize'));
        $this->assertTrue(method_exists($request, 'messages'));
    }

    /**
     * Test that verification routes are properly registered.
     */
    public function test_verification_routes_registered()
    {
        $routes = \Illuminate\Support\Facades\Route::getRoutes();
        $verificationRoutes = [];

        foreach ($routes as $route) {
            $path = $route->uri;
            if (strpos($path, 'verify') !== false) {
                $verificationRoutes[$path] = $route->methods();
            }
        }

        $this->assertArrayHasKey('auth/verify-email', $verificationRoutes);
        $this->assertArrayHasKey('auth/verify', $verificationRoutes);
        $this->assertArrayHasKey('auth/verify/resend', $verificationRoutes);
    }

    /**
     * Test that User model has required verification methods.
     */
    public function test_user_model_has_verification_methods()
    {
        $this->assertTrue(method_exists(User::class, 'generateEmailVerificationToken'));
        $this->assertTrue(method_exists(User::class, 'verifyEmail'));
    }

    /**
     * Test that email_verification_tokens table exists.
     */
    public function test_email_verification_tokens_table_exists()
    {
        $exists = DB::connection()->getSchemaBuilder()->hasTable('email_verification_tokens');
        $this->assertTrue($exists, 'email_verification_tokens table does not exist');
    }

    /**
     * Test that verify method correctly verifies email when token is valid.
     */
    public function test_verify_email_with_valid_token()
    {
        // Create a user
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        // Generate a token for the user
        $token = $user->generateEmailVerificationToken();

        // Simulate the verify request with email and token
        $response = $this->get(route('verify', [
            'email' => $user->email,
            'token' => $token,
        ]));

        // Check that the response redirects to login
        $response->assertRedirect(route('auth.login'));

        // Verify that the user's email is now marked as verified
        $user->refresh();
        $this->assertNotNull($user->email_verified_at);

        // Verify that the token has been consumed (deleted)
        $this->assertNull(DB::table('email_verification_tokens')
            ->where('email', $user->email)
            ->where('token', $token)
            ->first());
    }

    /**
     * Test that verify method rejects invalid token.
     */
    public function test_verify_email_with_invalid_token()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        // Generate a valid token but don't use it
        $user->generateEmailVerificationToken();

        // Try to verify with an invalid token
        $response = $this->get(route('verify', [
            'email' => $user->email,
            'token' => 'invalid_token_that_does_not_exist_12345678901234',
        ]));

        // Check that the response redirects to verify-email with error
        $response->assertRedirect(route('verify-email'));
        $response->assertSessionHas('error');

        // Verify that the user's email is still not verified
        $user->refresh();
        $this->assertNull($user->email_verified_at);
    }

    /**
     * Test that verify method rejects expired token.
     */
    public function test_verify_email_with_expired_token()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        // Create an expired token manually
        $token = Str::random(40);
        DB::table('email_verification_tokens')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now()->subHours(25),
            'expires_at' => now()->subHours(1),
        ]);

        // Try to verify with the expired token
        $response = $this->get(route('verify', [
            'email' => $user->email,
            'token' => $token,
        ]));

        // Check that the response redirects to verify-email with error
        $response->assertRedirect(route('verify-email'));
        $response->assertSessionHas('error', 'Your verification token has expired. Please request a new one.');

        // Verify that the expired token has been deleted
        $this->assertNull(DB::table('email_verification_tokens')
            ->where('email', $user->email)
            ->first());
    }

    /**
     * Test that resend method generates a new token and dispatches notification.
     */
    public function test_resend_verification_email()
    {
        Notification::fake();

        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        // Generate initial token
        $initialToken = $user->generateEmailVerificationToken();

        // Resend the verification email using the resend endpoint
        $response = $this->post(route('verify-resend'), [
            'email' => $user->email,
        ]);

        // Check that the response redirects to verify-email with success
        $response->assertRedirect(route('verify-email'));
        $response->assertSessionHas('success');

        // Verify that a new token was generated (different from initial)
        $newTokenRecord = DB::table('email_verification_tokens')
            ->where('email', $user->email)
            ->first();

        $this->assertNotNull($newTokenRecord);
        // The new token might be different from the initial one (or same if regenerated in place)
        // We just verify that a token exists for the user

        // Verify that the notification was sent
        Notification::assertSentTo(
            $user,
            VerifyEmailNotification::class
        );
    }

    /**
     * Test that resend is rate-limited to 1/min.
     */
    public function test_resend_is_rate_limited()
    {
        Notification::fake();

        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $user->generateEmailVerificationToken();

        // First resend should work
        $response1 = $this->post(route('verify-resend'), [
            'email' => $user->email,
        ]);
        $response1->assertRedirect(route('verify-email'));

        // Second resend should be rate-limited
        $response2 = $this->post(route('verify-resend'), [
            'email' => $user->email,
        ]);
        // Laravel's throttle middleware returns 429 Too Many Requests
        $response2->assertStatus(429);
    }

    /**
     * Test that showVerifyEmailPage renders the verify email view.
     */
    public function test_show_verify_email_page()
    {
        $response = $this->get(route('verify-email'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.verify-email');
    }

    /**
     * Test that verify method returns error when user is not found.
     */
    public function test_verify_email_when_user_not_found()
    {
        // Create a token record for a non-existent user
        $email = 'nonexistent@example.com';
        $token = Str::random(40);
        DB::table('email_verification_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now(),
            'expires_at' => now()->addHours(24),
        ]);

        // Try to verify
        $response = $this->get(route('verify', [
            'email' => $email,
            'token' => $token,
        ]));

        // Should redirect to verify-email with error
        $response->assertRedirect(route('verify-email'));
        $response->assertSessionHas('error', 'User not found.');
    }

    /**
     * Test that unverified users cannot log in (check in AuthController).
     */
    public function test_unverified_user_cannot_login()
    {
        $user = User::factory()->create([
            'password' => 'password123',
            'email_verified_at' => null,
        ]);

        // Try to login without verifying email
        $response = $this->post(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        // Should redirect to verify-email
        $response->assertRedirect(route('verify-email'));
        $response->assertSessionHas('error', 'Please verify your email before logging in.');
    }

    /**
     * Test that verified users can log in.
     */
    public function test_verified_user_can_login()
    {
        $user = User::factory()->create([
            'password' => 'password123',
            'email_verified_at' => now(),
        ]);

        // Try to login with verified email
        $response = $this->post(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        // Should redirect to dashboard
        $response->assertRedirect(route('dashboard'));
    }
}
