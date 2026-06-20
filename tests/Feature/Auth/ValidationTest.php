<?php

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use Tests\TestCase;

class ValidationTest extends TestCase
{
    /**
     * Test RegisterRequest validation - missing name
     */
    public function test_register_validation_missing_name(): void
    {
        $request = new RegisterRequest();
        $request->initialize([], [], [], [], [], [], [], [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);
        $validator = validator($request->all(), $request->rules());
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
    }

    /**
     * Test RegisterRequest validation - missing email
     */
    public function test_register_validation_missing_email(): void
    {
        $request = new RegisterRequest();
        $request->initialize([], [], [], [], [], [], [], [
            'name' => 'Test User',
            'password' => 'password123',
        ]);
        $validator = validator($request->all(), $request->rules());
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
    }

    /**
     * Test RegisterRequest validation - invalid email format
     */
    public function test_register_validation_invalid_email(): void
    {
        $request = new RegisterRequest();
        $request->initialize([], [], [], [], [], [], [], [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'password' => 'password123',
        ]);
        $validator = validator($request->all(), $request->rules());
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
    }

    /**
     * Test RegisterRequest validation - missing password
     */
    public function test_register_validation_missing_password(): void
    {
        $request = new RegisterRequest();
        $request->initialize([], [], [], [], [], [], [], [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $validator = validator($request->all(), $request->rules());
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('password', $validator->errors()->toArray());
    }

    /**
     * Test RegisterRequest validation - password too short
     */
    public function test_register_validation_password_too_short(): void
    {
        $request = new RegisterRequest();
        $request->initialize([], [], [], [], [], [], [], [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'pass123',
        ]);
        $validator = validator($request->all(), $request->rules());
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('password', $validator->errors()->toArray());
    }

    /**
     * Test LoginRequest validation - missing email
     */
    public function test_login_validation_missing_email(): void
    {
        $request = new LoginRequest();
        $request->initialize([], [], [], [], [], [], [], [
            'password' => 'password123',
        ]);
        $validator = validator($request->all(), $request->rules());
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
    }

    /**
     * Test LoginRequest validation - invalid email format
     */
    public function test_login_validation_invalid_email(): void
    {
        $request = new LoginRequest();
        $request->initialize([], [], [], [], [], [], [], [
            'email' => 'invalid-email',
            'password' => 'password123',
        ]);
        $validator = validator($request->all(), $request->rules());
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
    }

    /**
     * Test LoginRequest validation - missing password
     */
    public function test_login_validation_missing_password(): void
    {
        $request = new LoginRequest();
        $request->initialize([], [], [], [], [], [], [], [
            'email' => 'test@example.com',
        ]);
        $validator = validator($request->all(), $request->rules());
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('password', $validator->errors()->toArray());
    }
}
