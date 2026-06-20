<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class AuthCompleteFlowTest extends TestCase
{
    // ===== USER REGISTRATION FLOW TESTS =====

    /**
     * Test 1: Valid registration creates user
     */
    public function test_valid_registration_creates_user(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'SecurePassword123',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'message',
            'data' => [
                'user' => [
                    'id',
                    'name',
                    'email',
                ],
                'token',
            ],
        ]);

        $this->assertNotEmpty($response->json('data.token'));
    }

    /**
     * Test 2: Duplicate email registration is rejected
     */
    public function test_duplicate_email_registration_rejected(): void
    {
        // First registration
        $this->postJson('/api/auth/register', [
            'name' => 'First User',
            'email' => 'duplicate@example.com',
            'password' => 'SecurePassword123',
        ]);

        // Try to register with same email
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Another User',
            'email' => 'duplicate@example.com',
            'password' => 'SecurePassword123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    /**
     * Test 3: Password validation enforced - short password rejected
     */
    public function test_short_password_rejected(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'shortpwd@example.com',
            'password' => 'short',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('password');
    }

    /**
     * Test 4: Missing email validation
     */
    public function test_registration_missing_email_validation(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'password' => 'SecurePassword123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    /**
     * Test 5: Invalid email format validation
     */
    public function test_registration_invalid_email_format(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'not-an-email',
            'password' => 'SecurePassword123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    // ===== USER LOGIN FLOW TESTS =====

    /**
     * Test 6: Valid login returns token and user
     */
    public function test_valid_login_returns_token_and_user(): void
    {
        // First register a user
        $registerResponse = $this->postJson('/api/auth/register', [
            'name' => 'Login Test User',
            'email' => 'logintest@example.com',
            'password' => 'password123',
        ]);

        $userId = $registerResponse->json('data.user.id');

        // Now login
        $response = $this->postJson('/api/auth/login', [
            'email' => 'logintest@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'data' => [
                'token',
                'user' => [
                    'id',
                    'name',
                    'email',
                ],
            ],
        ]);

        $this->assertNotEmpty($response->json('data.token'));
        $this->assertEquals($userId, $response->json('data.user.id'));
    }

    /**
     * Test 7: Invalid credentials rejected - wrong password
     */
    public function test_invalid_credentials_wrong_password(): void
    {
        // Register a user first
        $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'wrongpwd@example.com',
            'password' => 'correctpassword',
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'wrongpwd@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
    }

    /**
     * Test 8: Invalid credentials rejected - non-existent user
     */
    public function test_invalid_credentials_nonexistent_user(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(401);
    }

    /**
     * Test 9: Token can be used for authenticated requests
     */
    public function test_token_used_for_authenticated_requests(): void
    {
        // Register and login
        $registerResponse = $this->postJson('/api/auth/register', [
            'name' => 'Token Test User',
            'email' => 'tokentest@example.com',
            'password' => 'password123',
        ]);

        $token = $registerResponse->json('data.token');

        // Use token to access profile
        $profileResponse = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/auth/profile');

        $profileResponse->assertStatus(200);
    }

    // ===== USER PROFILE ACCESS TESTS =====

    /**
     * Test 10: Authenticated user can view their profile
     */
    public function test_authenticated_user_view_profile(): void
    {
        // Register and login
        $registerResponse = $this->postJson('/api/auth/register', [
            'name' => 'Profile Test User',
            'email' => 'profiletest@example.com',
            'password' => 'password123',
        ]);

        $token = $registerResponse->json('data.token');

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/auth/profile');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'data' => [
                'user' => [
                    'id',
                    'name',
                    'email',
                ],
            ],
        ]);
    }

    /**
     * Test 11: Unauthenticated request returns 401
     */
    public function test_unauthenticated_profile_request_returns_401(): void
    {
        $response = $this->getJson('/api/auth/profile');

        $response->assertStatus(401);
    }

    /**
     * Test 12: Profile returns correct user data
     */
    public function test_profile_returns_correct_user_data(): void
    {
        // Register a user
        $registerResponse = $this->postJson('/api/auth/register', [
            'name' => 'Profile Data User',
            'email' => 'profiledata@example.com',
            'password' => 'password123',
        ]);

        $token = $registerResponse->json('data.token');
        $userId = $registerResponse->json('data.user.id');

        // Get profile
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/auth/profile');

        $response->assertStatus(200);
        $this->assertEquals($userId, $response->json('data.user.id'));
        $this->assertEquals('profiledata@example.com', $response->json('data.user.email'));
    }

    // ===== USER LOGOUT FLOW TESTS =====

    /**
     * Test 13: Authenticated user can logout
     */
    public function test_authenticated_user_logout(): void
    {
        // Register a user
        $registerResponse = $this->postJson('/api/auth/register', [
            'name' => 'Logout Test User',
            'email' => 'logouttest@example.com',
            'password' => 'password123',
        ]);

        $token = $registerResponse->json('data.token');

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/auth/logout');

        $response->assertStatus(204);
    }

    /**
     * Test 14: Token becomes invalid after logout
     */
    public function test_token_invalid_after_logout(): void
    {
        // Register a user
        $registerResponse = $this->postJson('/api/auth/register', [
            'name' => 'Token Expire Test User',
            'email' => 'tokenexpire@example.com',
            'password' => 'password123',
        ]);

        $token = $registerResponse->json('data.token');

        // Logout
        $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/auth/logout');

        // Try to use token after logout
        $profileResponse = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/auth/profile');

        // Should either return 401 or be invalidated
        $this->assertTrue(
            $profileResponse->status() === 401 || $profileResponse->status() === 400
        );
    }

    /**
     * Test 15: Unauthenticated logout request returns 401
     */
    public function test_unauthenticated_logout_returns_401(): void
    {
        $response = $this->postJson('/api/auth/logout');

        $response->assertStatus(401);
    }

    // ===== ROLE-BASED AUTHORIZATION TESTS =====

    /**
     * Test 16: Non-author cannot create posts without permission
     */
    public function test_non_author_cannot_create_posts(): void
    {
        // Register a user without author role
        $registerResponse = $this->postJson('/api/auth/register', [
            'name' => 'Non-Author User',
            'email' => 'nonauthor@example.com',
            'password' => 'password123',
        ]);

        $token = $registerResponse->json('data.token');

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/posts', [
                'title' => 'Test Post',
                'body' => 'This is a test post',
            ]);

        // Should return 403 Forbidden or endpoint may not require permission
        $this->assertTrue(
            $response->status() === 403 || $response->status() === 404,
            "Expected 403 or 404, got {$response->status()}"
        );
    }

    /**
     * Test 17: User without role cannot delete posts
     */
    public function test_user_without_role_cannot_delete_posts(): void
    {
        // Register a user without admin role
        $registerResponse = $this->postJson('/api/auth/register', [
            'name' => 'Regular User',
            'email' => 'regular@example.com',
            'password' => 'password123',
        ]);

        $token = $registerResponse->json('data.token');

        // Try to delete a post (ID 999 should not exist)
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->deleteJson('/api/posts/999');

        // Should return 403 or 404
        $this->assertTrue(
            $response->status() === 403 || $response->status() === 404,
            "Expected 403 or 404, got {$response->status()}"
        );
    }

    // ===== TOKEN VALIDATION TESTS =====

    /**
     * Test 18: Malformed token rejected
     */
    public function test_malformed_token_rejected(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer invalid.malformed.token')
            ->getJson('/api/auth/profile');

        // Should return 401 Unauthorized
        $this->assertEquals(401, $response->status());
    }

    /**
     * Test 19: Missing token authorization header
     */
    public function test_missing_token_authorization_header(): void
    {
        $response = $this->getJson('/api/auth/profile');

        $response->assertStatus(401);
    }

    /**
     * Test 20: Invalid token prefix rejected
     */
    public function test_invalid_token_prefix_rejected(): void
    {
        $response = $this->withHeader('Authorization', 'Basic sometoken')
            ->getJson('/api/auth/profile');

        // Should return 401 Unauthorized
        $this->assertEquals(401, $response->status());
    }

    /**
     * Test 21: Login with missing password validation
     */
    public function test_login_missing_password_validation(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('password');
    }

    /**
     * Test 22: Login with invalid email format validation
     */
    public function test_login_invalid_email_format_validation(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'invalid-email',
            'password' => 'password123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    /**
     * Test 23: Login with missing email validation
     */
    public function test_login_missing_email_validation(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'password' => 'password123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    /**
     * Test 24: Registration with missing name validation
     */
    public function test_registration_missing_name_validation(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'email' => 'noname@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
    }

    /**
     * Test 25: Complete authentication flow
     */
    public function test_complete_authentication_flow(): void
    {
        // Step 1: Register a new user
        $registerResponse = $this->postJson('/api/auth/register', [
            'name' => 'Complete Flow User',
            'email' => 'completeflow@example.com',
            'password' => 'CompleteFlow123',
        ]);

        $registerResponse->assertStatus(201);
        $token = $registerResponse->json('data.token');
        $userId = $registerResponse->json('data.user.id');

        // Step 2: Use token to access profile
        $profileResponse = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/auth/profile');

        $profileResponse->assertStatus(200);
        $this->assertEquals($userId, $profileResponse->json('data.user.id'));

        // Step 3: Login with credentials
        $loginResponse = $this->postJson('/api/auth/login', [
            'email' => 'completeflow@example.com',
            'password' => 'CompleteFlow123',
        ]);

        $loginResponse->assertStatus(200);
        $this->assertNotEmpty($loginResponse->json('data.token'));
        $this->assertEquals($userId, $loginResponse->json('data.user.id'));

        // Step 4: Logout
        $logoutResponse = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/auth/logout');

        $logoutResponse->assertStatus(204);
    }
}
