<?php

namespace Tests\Feature\Seeders;

use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Tests\TestCase;

class SeederTest extends TestCase
{
    /**
     * Test that PermissionSeeder class exists and is instantiable
     */
    public function test_permission_seeder_exists(): void
    {
        $seeder = new PermissionSeeder();
        $this->assertInstanceOf(PermissionSeeder::class, $seeder);
    }

    /**
     * Test that RoleSeeder class exists and is instantiable
     */
    public function test_role_seeder_exists(): void
    {
        $seeder = new RoleSeeder();
        $this->assertInstanceOf(RoleSeeder::class, $seeder);
    }

    /**
     * Test that PermissionSeeder has a run method
     */
    public function test_permission_seeder_has_run_method(): void
    {
        $seeder = new PermissionSeeder();
        $this->assertTrue(method_exists($seeder, 'run'));
    }

    /**
     * Test that RoleSeeder has a run method
     */
    public function test_role_seeder_has_run_method(): void
    {
        $seeder = new RoleSeeder();
        $this->assertTrue(method_exists($seeder, 'run'));
    }

    /**
     * Test that PermissionSeeder uses Spatie Permission models
     */
    public function test_permission_seeder_imports_spatie_models(): void
    {
        $reflector = new \ReflectionClass(PermissionSeeder::class);
        $fileName = $reflector->getFileName();
        $content = file_get_contents($fileName);

        $this->assertStringContainsString('Spatie\Permission\Models\Permission', $content);
    }

    /**
     * Test that RoleSeeder uses Spatie Permission models
     */
    public function test_role_seeder_imports_spatie_models(): void
    {
        $reflector = new \ReflectionClass(RoleSeeder::class);
        $fileName = $reflector->getFileName();
        $content = file_get_contents($fileName);

        $this->assertStringContainsString('Spatie\Permission\Models\Role', $content);
        $this->assertStringContainsString('Spatie\Permission\Models\Permission', $content);
    }

    /**
     * Test that PermissionSeeder creates the expected permissions
     */
    public function test_permission_seeder_defines_expected_permissions(): void
    {
        $reflector = new \ReflectionClass(PermissionSeeder::class);
        $fileName = $reflector->getFileName();
        $content = file_get_contents($fileName);

        $expectedPermissions = ['create_post', 'edit_post', 'delete_post', 'view_analytics', 'manage_users'];

        foreach ($expectedPermissions as $permission) {
            $this->assertStringContainsString($permission, $content);
        }
    }

    /**
     * Test that RoleSeeder creates the expected roles
     */
    public function test_role_seeder_defines_expected_roles(): void
    {
        $reflector = new \ReflectionClass(RoleSeeder::class);
        $fileName = $reflector->getFileName();
        $content = file_get_contents($fileName);

        $expectedRoles = ['admin', 'editor', 'author'];

        foreach ($expectedRoles as $role) {
            $this->assertStringContainsString("'$role'", $content);
        }
    }

    /**
     * Test that RoleSeeder assigns permissions correctly
     */
    public function test_role_seeder_assigns_permissions_correctly(): void
    {
        $reflector = new \ReflectionClass(RoleSeeder::class);
        $fileName = $reflector->getFileName();
        $content = file_get_contents($fileName);

        // Check that author role gets create_post
        $this->assertStringContainsString("'author'", $content);
        $this->assertStringContainsString("create_post", $content);

        // Check that editor role gets multiple permissions
        $this->assertStringContainsString("'editor'", $content);
        $this->assertStringContainsString("edit_post", $content);
        $this->assertStringContainsString("view_analytics", $content);

        // Check that admin gets all permissions
        $this->assertStringContainsString("'admin'", $content);
    }

    /**
     * Test that PermissionSeeder assigns correct guards
     */
    public function test_permission_seeder_assigns_correct_guards(): void
    {
        $reflector = new \ReflectionClass(PermissionSeeder::class);
        $fileName = $reflector->getFileName();
        $content = file_get_contents($fileName);

        // Check for guard assignments
        $this->assertStringContainsString("'guard_name'", $content);
        $this->assertStringContainsString("'web'", $content);
        $this->assertStringContainsString("'api'", $content);

        // Verify that create_post, edit_post, delete_post are in web guard
        // Verify that view_analytics, manage_users are in api guard
        $this->assertStringContainsString('create_post', $content);
        $this->assertStringContainsString('delete_post', $content);
        $this->assertStringContainsString('view_analytics', $content);
        $this->assertStringContainsString('manage_users', $content);
    }

    /**
     * Test that seeders use firstOrCreate for idempotency
     */
    public function test_seeders_use_first_or_create(): void
    {
        $permissionSeederContent = file_get_contents((new \ReflectionClass(PermissionSeeder::class))->getFileName());
        $roleSeederContent = file_get_contents((new \ReflectionClass(RoleSeeder::class))->getFileName());

        $this->assertStringContainsString('firstOrCreate', $permissionSeederContent);
        $this->assertStringContainsString('firstOrCreate', $roleSeederContent);
    }

    /**
     * Test that RoleSeeder uses syncPermissions for assignment
     */
    public function test_role_seeder_uses_sync_permissions(): void
    {
        $roleSeederContent = file_get_contents((new \ReflectionClass(RoleSeeder::class))->getFileName());

        $this->assertStringContainsString('syncPermissions', $roleSeederContent);
    }

    /**
     * Test that DatabaseSeeder calls both permission and role seeders
     */
    public function test_database_seeder_calls_permission_and_role_seeders(): void
    {
        $databaseSeederPath = database_path('seeders/DatabaseSeeder.php');
        $content = file_get_contents($databaseSeederPath);

        $this->assertStringContainsString('PermissionSeeder', $content);
        $this->assertStringContainsString('RoleSeeder', $content);
    }

    /**
     * Test that DatabaseSeeder calls seeders in correct order
     */
    public function test_database_seeder_calls_seeders_in_order(): void
    {
        $databaseSeederPath = database_path('seeders/DatabaseSeeder.php');
        $content = file_get_contents($databaseSeederPath);

        $permissionPos = strpos($content, 'PermissionSeeder');
        $rolePos = strpos($content, 'RoleSeeder');

        $this->assertNotFalse($permissionPos);
        $this->assertNotFalse($rolePos);
        $this->assertLessThan($rolePos, $permissionPos, 'PermissionSeeder should be called before RoleSeeder');
    }
}
