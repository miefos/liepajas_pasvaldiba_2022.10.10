<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            [
                'name' => 'permission_create',
            ],
            [
                'name' => 'permission_read',
            ],
            [
                'name' => 'permission_update',
            ],
            [
                'name' => 'permission_delete',
            ],
            [
                'name' => 'permission_export',
            ],
            [
                'name' => 'role_create',
            ],
            [
                'name' => 'role_read',
            ],
            [
                'name' => 'role_update',
            ],
            [
                'name' => 'role_delete',
            ],
            [
                'name' => 'role_export',
            ],
            [
                'name' => 'user_create',
            ],
            [
                'name' => 'user_read',
            ],
            [
                'name' => 'user_update',
            ],
            [
                'name' => 'user_delete',
            ],
            [
                'name' => 'user_export',
            ],

            // autogenerated here
            [
                'name' => 'entity_level_create',
            ],            [
                'name' => 'entity_level_read',
            ],            [
                'name' => 'entity_level_update',
            ],            [
                'name' => 'entity_level_delete',
            ],            [
                'name' => 'entity_level_export',
            ],
            [
                'name' => 'complete_level_create',
            ],            [
                'name' => 'complete_level_read',
            ],            [
                'name' => 'complete_level_update',
            ],            [
                'name' => 'complete_level_delete',
            ],            [
                'name' => 'complete_level_export',
            ],
            [
                'name' => 'goal_create',
            ],            [
                'name' => 'goal_read',
            ],            [
                'name' => 'goal_update',
            ],            [
                'name' => 'goal_delete',
            ],            [
                'name' => 'goal_export',
            ],
            [
                'name' => 'entity_create',
            ],            [
                'name' => 'entity_read',
            ],            [
                'name' => 'entity_update',
            ],            [
                'name' => 'entity_delete',
            ],            [
                'name' => 'entity_export',
            ],
        ];
        \Spatie\Permission\Models\Permission::insert($permissions);
    }
}
