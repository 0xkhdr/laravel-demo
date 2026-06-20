<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define permissions with their guards
        $permissions = [
            ['name' => 'create_post', 'guard_name' => 'web'],
            ['name' => 'edit_post', 'guard_name' => 'web'],
            ['name' => 'delete_post', 'guard_name' => 'web'],
            ['name' => 'view_analytics', 'guard_name' => 'api'],
            ['name' => 'manage_users', 'guard_name' => 'api'],
        ];

        // Create permissions if they don't exist
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                ['guard_name' => $permission['guard_name']]
            );
        }
    }
}
