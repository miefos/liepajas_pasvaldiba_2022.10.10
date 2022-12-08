<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $allPermissions = Permission::all();

        $roles = [1,2,3]; // Super Admin, Admin, Darbinieks
        $notPermissions = [
            1 => [],
            2 => ['complete_level', 'entity_level'],
        ];

        $permissions = [
            3 => [
                'goal_create',
                'goal_read',
                'goal_update',
                'goal_export',
                'goal_delete',
                'goal_accept',
                'task_create',
                'task_read',
                'task_update',
                'task_export',
                'task_delete',
            ]
        ];

        foreach ($roles as $roleId) {

            $ps = $allPermissions->filter(function ($permission) use ($notPermissions, $roleId, $permissions) {
                if (isset($notPermissions[$roleId])) {
                    foreach ($notPermissions[$roleId] as $notPermission) {
                        if (str_starts_with($permission->name, $notPermission))
                            return false;
                    }
                } else if (isset($permissions[$roleId])) {
                    foreach ($permissions[$roleId] as $p) {
                        if ($permission->name === $p) {
                            return true;
                        }
                    }
                    return false;
                } else {
                    echo "ROLE $roleId PERMISSION SETTINGS NOT FOUND!";
                }

                return true;
            });

            Role::findOrFail($roleId)->permissions()->sync($ps->pluck('id'));
        }
    }
}
