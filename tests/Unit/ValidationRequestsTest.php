<?php

namespace Tests\Unit;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use Tests\TestCase;

class ValidationRequestsTest extends TestCase
{
    /**
     * Test that RegisterRequest class exists and can be instantiated.
     */
    public function test_register_request_can_be_instantiated(): void
    {
        $this->assertTrue(class_exists(RegisterRequest::class));
        $request = new RegisterRequest();
        $this->assertInstanceOf(RegisterRequest::class, $request);
    }

    /**
     * Test that RegisterRequest has correct validation rules.
     */
    public function test_register_request_rules(): void
    {
        $request = new RegisterRequest();
        $rules = $request->rules();

        $this->assertArrayHasKey('name', $rules);
        $this->assertArrayHasKey('email', $rules);
        $this->assertArrayHasKey('password', $rules);

        $this->assertStringContainsString('required', $rules['name']);
        $this->assertStringContainsString('unique', $rules['email']);
        $this->assertStringContainsString('min:8', $rules['password']);
        $this->assertStringContainsString('confirmed', $rules['password']);
    }

    /**
     * Test that LoginRequest class exists and can be instantiated.
     */
    public function test_login_request_can_be_instantiated(): void
    {
        $this->assertTrue(class_exists(LoginRequest::class));
        $request = new LoginRequest();
        $this->assertInstanceOf(LoginRequest::class, $request);
    }

    /**
     * Test that LoginRequest has correct validation rules.
     */
    public function test_login_request_rules(): void
    {
        $request = new LoginRequest();
        $rules = $request->rules();

        $this->assertArrayHasKey('email', $rules);
        $this->assertArrayHasKey('password', $rules);

        $this->assertStringContainsString('required', $rules['email']);
        $this->assertStringContainsString('required', $rules['password']);
    }

    /**
     * Test that ResetPasswordRequest class exists and can be instantiated.
     */
    public function test_reset_password_request_can_be_instantiated(): void
    {
        $this->assertTrue(class_exists(ResetPasswordRequest::class));
        $request = new ResetPasswordRequest();
        $this->assertInstanceOf(ResetPasswordRequest::class, $request);
    }

    /**
     * Test that ResetPasswordRequest has correct validation rules.
     */
    public function test_reset_password_request_rules(): void
    {
        $request = new ResetPasswordRequest();
        $rules = $request->rules();

        $this->assertArrayHasKey('password', $rules);
        $this->assertStringContainsString('required', $rules['password']);
        $this->assertStringContainsString('min:8', $rules['password']);
        $this->assertStringContainsString('confirmed', $rules['password']);
    }

    /**
     * Test that ChangePasswordRequest class exists and can be instantiated.
     */
    public function test_change_password_request_can_be_instantiated(): void
    {
        $this->assertTrue(class_exists(ChangePasswordRequest::class));
        $request = new ChangePasswordRequest();
        $this->assertInstanceOf(ChangePasswordRequest::class, $request);
    }

    /**
     * Test that ChangePasswordRequest has correct validation rules.
     */
    public function test_change_password_request_rules(): void
    {
        $request = new ChangePasswordRequest();
        $rules = $request->rules();

        $this->assertArrayHasKey('current_password', $rules);
        $this->assertArrayHasKey('password', $rules);

        // current_password rule is an array with closure
        $this->assertIsArray($rules['current_password']);

        // password rule is a string
        $this->assertIsString($rules['password']);
        $this->assertStringContainsString('required', $rules['password']);
        $this->assertStringContainsString('min:8', $rules['password']);
        $this->assertStringContainsString('confirmed', $rules['password']);
        $this->assertStringContainsString('different', $rules['password']);
    }

    /**
     * Test that all request classes extend FormRequest.
     */
    public function test_all_requests_extend_form_request(): void
    {
        $this->assertTrue(is_subclass_of(RegisterRequest::class, \Illuminate\Foundation\Http\FormRequest::class));
        $this->assertTrue(is_subclass_of(LoginRequest::class, \Illuminate\Foundation\Http\FormRequest::class));
        $this->assertTrue(is_subclass_of(ResetPasswordRequest::class, \Illuminate\Foundation\Http\FormRequest::class));
        $this->assertTrue(is_subclass_of(ChangePasswordRequest::class, \Illuminate\Foundation\Http\FormRequest::class));
    }

    /**
     * Test that all request classes have messages() method.
     */
    public function test_all_requests_have_messages_method(): void
    {
        $this->assertTrue(method_exists(RegisterRequest::class, 'messages'));
        $this->assertTrue(method_exists(LoginRequest::class, 'messages'));
        $this->assertTrue(method_exists(ResetPasswordRequest::class, 'messages'));
        $this->assertTrue(method_exists(ChangePasswordRequest::class, 'messages'));
    }
}
