<?php

namespace Tests\Feature\Auth;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\MeController;
use App\Http\Controllers\Auth\LogoutController;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * Test that RegisterController can be instantiated
     */
    public function test_register_controller_exists(): void
    {
        $controller = new RegisterController();
        $this->assertInstanceOf(RegisterController::class, $controller);
    }

    /**
     * Test that LoginController can be instantiated
     */
    public function test_login_controller_exists(): void
    {
        $controller = new LoginController();
        $this->assertInstanceOf(LoginController::class, $controller);
    }

    /**
     * Test that MeController can be instantiated
     */
    public function test_me_controller_exists(): void
    {
        $controller = new MeController();
        $this->assertInstanceOf(MeController::class, $controller);
    }

    /**
     * Test that LogoutController can be instantiated
     */
    public function test_logout_controller_exists(): void
    {
        $controller = new LogoutController();
        $this->assertInstanceOf(LogoutController::class, $controller);
    }

    /**
     * Test that controllers extend the base Controller
     */
    public function test_controllers_extend_controller(): void
    {
        $this->assertTrue(is_subclass_of(RegisterController::class, 'App\Http\Controllers\Controller'));
        $this->assertTrue(is_subclass_of(LoginController::class, 'App\Http\Controllers\Controller'));
        $this->assertTrue(is_subclass_of(MeController::class, 'App\Http\Controllers\Controller'));
        $this->assertTrue(is_subclass_of(LogoutController::class, 'App\Http\Controllers\Controller'));
    }

    /**
     * Test that routes are registered correctly
     */
    public function test_auth_routes_exist(): void
    {
        $routes = \Illuminate\Support\Facades\Route::getRoutes();

        // Get all route URIs
        $routeUris = array_map(function ($route) {
            return $route->uri;
        }, $routes->getRoutes());

        // Check if auth routes exist
        $this->assertContains('api/auth/register', $routeUris);
        $this->assertContains('api/auth/login', $routeUris);
        $this->assertContains('api/auth/profile', $routeUris);
        $this->assertContains('api/auth/logout', $routeUris);
    }
}
