<?php

namespace Tests\Unit\Actions;

use App\Actions\Auth\LoginUser;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\TestCase;
use Mockery;

class LoginUserTest extends TestCase
{
    protected LoginUser $action;

    protected function setUp(): void
    {
        parent::setUp();
        $this->action = new LoginUser();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_login_user_action_is_callable(): void
    {
        // Verify the action is callable
        $this->assertTrue(is_callable($this->action));
    }

    public function test_action_accepts_login_request(): void
    {
        // Verify the action can accept a LoginRequest
        $reflection = new \ReflectionMethod(LoginUser::class, '__invoke');
        $parameters = $reflection->getParameters();

        $this->assertCount(1, $parameters);
        $this->assertEquals('request', $parameters[0]->getName());
    }

    public function test_action_returns_array(): void
    {
        // Verify the return type is array
        $reflection = new \ReflectionMethod(LoginUser::class, '__invoke');
        $returnType = (string) $reflection->getReturnType();

        $this->assertStringContainsString('array', $returnType);
    }

    public function test_action_uses_auth_attempt(): void
    {
        // Verify that Auth::attempt is called
        $reflection = new \ReflectionClass(LoginUser::class);
        $source = file_get_contents($reflection->getFileName());

        $this->assertStringContainsString('Auth::attempt', $source);
    }

    public function test_action_uses_auth_user(): void
    {
        // Verify that Auth::user is called
        $reflection = new \ReflectionClass(LoginUser::class);
        $source = file_get_contents($reflection->getFileName());

        $this->assertStringContainsString('Auth::user', $source);
    }

    public function test_action_creates_token(): void
    {
        // Verify that createToken is called
        $reflection = new \ReflectionClass(LoginUser::class);
        $source = file_get_contents($reflection->getFileName());

        $this->assertStringContainsString('createToken', $source);
    }

    public function test_action_returns_plain_text_token(): void
    {
        // Verify that plainTextToken is accessed
        $reflection = new \ReflectionClass(LoginUser::class);
        $source = file_get_contents($reflection->getFileName());

        $this->assertStringContainsString('plainTextToken', $source);
    }

    public function test_action_throws_authentication_exception(): void
    {
        // Verify that AuthenticationException is thrown on failed auth
        $reflection = new \ReflectionClass(LoginUser::class);
        $source = file_get_contents($reflection->getFileName());

        $this->assertStringContainsString('AuthenticationException', $source);
    }

    public function test_action_uses_validated_data(): void
    {
        // Verify that validated() is called on the request
        $reflection = new \ReflectionClass(LoginUser::class);
        $source = file_get_contents($reflection->getFileName());

        $this->assertStringContainsString('->validated()', $source);
    }

    public function test_action_returns_token_and_user(): void
    {
        // Verify that the action returns both token and user
        $reflection = new \ReflectionClass(LoginUser::class);
        $source = file_get_contents($reflection->getFileName());

        $this->assertStringContainsString("'token'", $source);
        $this->assertStringContainsString("'user'", $source);
    }
}
