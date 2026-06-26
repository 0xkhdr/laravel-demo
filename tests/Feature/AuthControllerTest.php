<?php

namespace Tests\Feature;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use App\Support\AuditLogger;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    /**
     * Test that AuthController exists and can be instantiated.
     */
    public function test_auth_controller_exists()
    {
        $this->assertTrue(class_exists(AuthController::class));
        $controller = app(AuthController::class);
        $this->assertInstanceOf(AuthController::class, $controller);
    }

    /**
     * Test that showRegisterForm method exists.
     */
    public function test_show_register_form_method_exists()
    {
        $controller = app(AuthController::class);
        $this->assertTrue(method_exists($controller, 'showRegisterForm'));
    }

    /**
     * Test that register method exists and accepts RegisterRequest.
     */
    public function test_register_method_exists()
    {
        $controller = app(AuthController::class);
        $this->assertTrue(method_exists($controller, 'register'));

        // Check method signature
        $reflection = new \ReflectionMethod($controller, 'register');
        $this->assertTrue($reflection->getNumberOfParameters() === 1);
    }

    /**
     * Test that showLoginForm method exists.
     */
    public function test_show_login_form_method_exists()
    {
        $controller = app(AuthController::class);
        $this->assertTrue(method_exists($controller, 'showLoginForm'));
    }

    /**
     * Test that login method exists and accepts LoginRequest.
     */
    public function test_login_method_exists()
    {
        $controller = app(AuthController::class);
        $this->assertTrue(method_exists($controller, 'login'));

        // Check method signature
        $reflection = new \ReflectionMethod($controller, 'login');
        $this->assertTrue($reflection->getNumberOfParameters() === 1);
    }

    /**
     * Test that logout method exists.
     */
    public function test_logout_method_exists()
    {
        $controller = app(AuthController::class);
        $this->assertTrue(method_exists($controller, 'logout'));
    }

    /**
     * Test that routes are properly registered.
     */
    public function test_auth_routes_registered()
    {
        $routes = \Illuminate\Support\Facades\Route::getRoutes();
        $authRoutes = [];

        foreach ($routes as $route) {
            $path = $route->uri;
            if (strpos($path, 'auth') !== false) {
                $authRoutes[$path] = $route->methods();
            }
        }

        $this->assertArrayHasKey('auth/register', $authRoutes);
        $this->assertArrayHasKey('auth/login', $authRoutes);
        $this->assertArrayHasKey('auth/logout', $authRoutes);
    }

    /**
     * Test that User model has required authentication methods.
     */
    public function test_user_model_has_auth_methods()
    {
        $this->assertTrue(method_exists(User::class, 'generateEmailVerificationToken'));
        $this->assertTrue(method_exists(User::class, 'verifyEmail'));
        $this->assertTrue(method_exists(User::class, 'revokeAllSessions'));
    }

    /**
     * Test that VerifyEmailNotification exists and is properly structured.
     */
    public function test_verify_email_notification_exists()
    {
        $this->assertTrue(class_exists(VerifyEmailNotification::class));
        $notification = new VerifyEmailNotification();
        $this->assertInstanceOf(VerifyEmailNotification::class, $notification);
        $this->assertTrue(method_exists($notification, 'toMail'));
    }

    /**
     * Test that AuditLogger has required methods.
     */
    public function test_audit_logger_has_methods()
    {
        $this->assertTrue(method_exists(AuditLogger::class, 'login'));
        $this->assertTrue(method_exists(AuditLogger::class, 'logout'));
        $this->assertTrue(method_exists(AuditLogger::class, 'passwordReset'));
        $this->assertTrue(method_exists(AuditLogger::class, 'passwordChange'));
    }

    /**
     * Test form request classes exist and have correct structure.
     */
    public function test_form_requests_exist()
    {
        $this->assertTrue(class_exists(RegisterRequest::class));
        $this->assertTrue(class_exists(LoginRequest::class));

        $registerRequest = new RegisterRequest();
        $this->assertTrue(method_exists($registerRequest, 'rules'));
        $this->assertTrue(method_exists($registerRequest, 'authorize'));

        $loginRequest = new LoginRequest();
        $this->assertTrue(method_exists($loginRequest, 'rules'));
        $this->assertTrue(method_exists($loginRequest, 'authorize'));
    }

    /**
     * Test that AuthController methods are callable.
     */
    public function test_auth_controller_methods_are_callable()
    {
        $controller = app(AuthController::class);

        $methods = [
            'showRegisterForm',
            'showLoginForm',
            'logout'
        ];

        foreach ($methods as $method) {
            $this->assertTrue(is_callable([$controller, $method]));
        }
    }
}
