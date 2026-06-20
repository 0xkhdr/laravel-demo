<?php

namespace Tests\Unit\Actions;

use App\Actions\Auth\GetAuthenticatedUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\TestCase;
use Mockery;

class GetAuthenticatedUserTest extends TestCase
{
    protected GetAuthenticatedUser $action;

    protected function setUp(): void
    {
        parent::setUp();
        $this->action = new GetAuthenticatedUser();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_action_is_callable(): void
    {
        // Verify the action is callable
        $this->assertTrue(is_callable($this->action));
    }

    public function test_action_accepts_request_parameter(): void
    {
        // Verify the action can accept a Request
        $reflection = new \ReflectionMethod(GetAuthenticatedUser::class, '__invoke');
        $parameters = $reflection->getParameters();

        $this->assertCount(1, $parameters);
        $this->assertEquals('request', $parameters[0]->getName());
    }

    public function test_action_returns_user(): void
    {
        // Verify the return type is User
        $reflection = new \ReflectionMethod(GetAuthenticatedUser::class, '__invoke');
        $returnType = (string) $reflection->getReturnType();

        $this->assertStringContainsString('User', $returnType);
    }

    public function test_action_uses_auth_user(): void
    {
        // Verify that Auth::user is called
        $reflection = new \ReflectionClass(GetAuthenticatedUser::class);
        $source = file_get_contents($reflection->getFileName());

        $this->assertStringContainsString('Auth::user', $source);
    }

    public function test_action_retrieves_authenticated_user(): void
    {
        // Mock the request
        $request = Mockery::mock('Illuminate\Http\Request');

        // Create a mock user with properties
        $user = new User();
        $user->id = 1;
        $user->email = 'test@example.com';

        // Mock Auth::user() to return the test user
        Auth::shouldReceive('user')
            ->once()
            ->andReturn($user);

        // Call the action
        $result = $this->action->__invoke($request);

        // Verify the user is returned
        $this->assertSame($user, $result);
        $this->assertEquals(1, $result->id);
        $this->assertEquals('test@example.com', $result->email);
    }
}
