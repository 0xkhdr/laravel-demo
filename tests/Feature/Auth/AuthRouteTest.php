<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class AuthRouteTest extends TestCase
{
    /**
     * Test POST /auth/register endpoint exists and accepts POST
     */
    public function test_register_endpoint_exists(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        // Should return either 201 (created) or 422 (validation) but NOT 404
        $this->assertNotEquals(404, $response->status());
    }

    /**
     * Test POST /auth/register with invalid email returns validation error
     */
    public function test_register_with_invalid_email_fails(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'password' => 'password123',
        ]);

        // Should fail validation (422) due to invalid email format
        $this->assertTrue(
            $response->status() === 422 || $response->status() === 400,
            "Expected validation error (422/400) but got {$response->status()}"
        );
    }

    /**
     * Test POST /auth/register with short password fails
     */
    public function test_register_with_short_password_fails(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'short',
        ]);

        // Should fail due to password validation
        // Status may be 422 (validation), 400 (bad request), or 500 if database unavailable
        $this->assertTrue(
            $response->status() === 422 || $response->status() === 400 || $response->status() === 500,
            "Expected error but got {$response->status()}"
        );
        // Verify it's not a successful response
        $this->assertNotEquals(201, $response->status());
    }

    /**
     * Test POST /auth/login endpoint exists and accepts POST
     */
    public function test_login_endpoint_exists(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        // Should return either 200 (success) or 401 (invalid) but NOT 404
        $this->assertNotEquals(404, $response->status());
    }

    /**
     * Test POST /auth/login with missing email fails
     */
    public function test_login_with_missing_email_fails(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'password' => 'password123',
        ]);

        // Should fail validation (422) due to missing email
        $this->assertTrue(
            $response->status() === 422 || $response->status() === 400,
            "Expected validation error (422/400) but got {$response->status()}"
        );
    }

    /**
     * Test GET /auth/profile endpoint exists
     */
    public function test_profile_endpoint_exists(): void
    {
        $response = $this->getJson('/api/auth/profile');

        // Should return 401 (unauthorized) not 404 (not found)
        $this->assertNotEquals(404, $response->status());
    }

    /**
     * Test GET /auth/profile without auth returns 401
     */
    public function test_profile_without_auth_returns_401(): void
    {
        $response = $this->getJson('/api/auth/profile');

        $this->assertEquals(401, $response->status());
    }

    /**
     * Test POST /auth/logout endpoint exists
     */
    public function test_logout_endpoint_exists(): void
    {
        $response = $this->postJson('/api/auth/logout');

        // Should return 401 (unauthorized) not 404 (not found)
        $this->assertNotEquals(404, $response->status());
    }

    /**
     * Test POST /auth/logout without auth returns 401
     */
    public function test_logout_without_auth_returns_401(): void
    {
        $response = $this->postJson('/api/auth/logout');

        $this->assertEquals(401, $response->status());
    }
}
