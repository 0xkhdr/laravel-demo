<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'create_posts',
            'edit_posts',
            'delete_posts',
            'view_posts',
            'delete_users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission],
                ['guard_name' => 'web']
            );
        }

        // Create author role with post permissions
        $authorRole = Role::firstOrCreate(
            ['name' => 'author'],
            ['guard_name' => 'web']
        );
        $authorRole->syncPermissions(['create_posts', 'edit_posts', 'delete_posts', 'view_posts']);

        // Create admin role with all permissions
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['guard_name' => 'web']
        );
        $adminRole->syncPermissions($permissions);
    }
}
