<?php

namespace Tests\Unit\Actions;

use App\Actions\Auth\LogoutUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\TestCase;
use Mockery;

class LogoutUserTest extends TestCase
{
    protected LogoutUser $action;

    protected function setUp(): void
    {
        parent::setUp();
        $this->action = new LogoutUser();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_logout_user_action_is_callable(): void
    {
        // Verify the action is callable
        $this->assertTrue(is_callable($this->action));
    }

    public function test_action_accepts_user_parameter(): void
    {
        // Verify the action can accept a User parameter
        $reflection = new \ReflectionMethod(LogoutUser::class, '__invoke');
        $parameters = $reflection->getParameters();

        $this->assertCount(1, $parameters);
        $this->assertEquals('user', $parameters[0]->getName());
    }

    public function test_action_returns_void(): void
    {
        // Verify the return type is void
        $reflection = new \ReflectionMethod(LogoutUser::class, '__invoke');
        $returnType = (string) $reflection->getReturnType();

        $this->assertStringContainsString('void', $returnType);
    }

    public function test_action_deletes_tokens(): void
    {
        // Verify that tokens()->delete() is called
        $reflection = new \ReflectionClass(LogoutUser::class);
        $source = file_get_contents($reflection->getFileName());

        $this->assertStringContainsString('tokens()', $source);
        $this->assertStringContainsString('->delete()', $source);
    }

    public function test_action_calls_auth_logout(): void
    {
        // Verify that Auth::logout() is called
        $reflection = new \ReflectionClass(LogoutUser::class);
        $source = file_get_contents($reflection->getFileName());

        $this->assertStringContainsString('Auth::logout()', $source);
    }
}
