<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all permissions
        $allPermissions = Permission::all()->pluck('name')->toArray();

        // Create author role with only create_post permission
        $authorRole = Role::firstOrCreate(
            ['name' => 'author'],
            ['guard_name' => 'web']
        );
        $authorRole->syncPermissions(['create_post']);

        // Create editor role with create_post, edit_post, and view_analytics
        $editorRole = Role::firstOrCreate(
            ['name' => 'editor'],
            ['guard_name' => 'web']
        );
        $editorRole->syncPermissions(['create_post', 'edit_post', 'view_analytics']);

        // Create admin role with all permissions
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['guard_name' => 'web']
        );
        $adminRole->syncPermissions($allPermissions);
    }
}
