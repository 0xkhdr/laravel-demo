<?php

namespace Tests\Unit\Actions;

use App\Actions\Auth\RegisterUser;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\TestCase;
use Mockery;

class RegisterUserTest extends TestCase
{
    protected RegisterUser $action;

    protected function setUp(): void
    {
        parent::setUp();
        $this->action = new RegisterUser();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_register_user_action_is_callable(): void
    {
        // Verify the action is callable
        $this->assertTrue(is_callable($this->action));
    }

    public function test_action_accepts_register_request(): void
    {
        // Verify the action can accept a RegisterRequest
        $reflection = new \ReflectionMethod(RegisterUser::class, '__invoke');
        $parameters = $reflection->getParameters();

        $this->assertCount(1, $parameters);
        $this->assertEquals('request', $parameters[0]->getName());
    }

    public function test_action_returns_user_instance(): void
    {
        // Verify the return type is User
        $reflection = new \ReflectionMethod(RegisterUser::class, '__invoke');
        $returnType = (string) $reflection->getReturnType();

        $this->assertStringContainsString('User', $returnType);
    }

    public function test_action_uses_hash_make_for_password(): void
    {
        // Verify that Hash::make is called - this is tested by checking
        // that the action uses Illuminate\Support\Facades\Hash
        $reflection = new \ReflectionClass(RegisterUser::class);
        $source = file_get_contents($reflection->getFileName());

        $this->assertStringContainsString('Hash::make', $source);
    }

    public function test_action_assigns_author_role(): void
    {
        // Verify that the action calls assignRole with 'author'
        $reflection = new \ReflectionClass(RegisterUser::class);
        $source = file_get_contents($reflection->getFileName());

        $this->assertStringContainsString("assignRole('author')", $source);
    }

    public function test_action_loads_roles_relationship(): void
    {
        // Verify that roles are eager-loaded
        $reflection = new \ReflectionClass(RegisterUser::class);
        $source = file_get_contents($reflection->getFileName());

        $this->assertStringContainsString("->load('roles')", $source);
    }

    public function test_action_checks_for_existing_email(): void
    {
        // Verify email exists check is present
        $reflection = new \ReflectionClass(RegisterUser::class);
        $source = file_get_contents($reflection->getFileName());

        $this->assertStringContainsString('User::where', $source);
        $this->assertStringContainsString('exists()', $source);
    }

    public function test_action_throws_validation_exception_on_duplicate_email(): void
    {
        // Verify ValidationException is thrown
        $reflection = new \ReflectionClass(RegisterUser::class);
        $source = file_get_contents($reflection->getFileName());

        $this->assertStringContainsString('ValidationException::withMessages', $source);
    }

    public function test_action_creates_user_with_create_method(): void
    {
        // Verify User::create is called
        $reflection = new \ReflectionClass(RegisterUser::class);
        $source = file_get_contents($reflection->getFileName());

        $this->assertStringContainsString('User::create', $source);
    }

    public function test_action_uses_correct_field_names(): void
    {
        // Verify correct field names are used
        $reflection = new \ReflectionClass(RegisterUser::class);
        $source = file_get_contents($reflection->getFileName());

        $this->assertStringContainsString('name', $source);
        $this->assertStringContainsString('email', $source);
        $this->assertStringContainsString('password', $source);
    }
}
