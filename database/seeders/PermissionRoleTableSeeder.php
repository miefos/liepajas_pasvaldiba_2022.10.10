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

        $roles = [1,2,3,4,5]; // Super Admin, Admin, Warehouse, Marketing, User
        $notPermissions = [
            1 => [],
            2 => ['role_', 'permission_'],
            3 => ['role_', 'permission_', 'user_'],
        ];

        $permissions = [
            4 => [
                'order_create',
                'order_read',
                'order_update',
                'order_export',
                'order_delete',
                'product_read',
                'order_status_read',
                'product_availability_status_read',
                'category_read',
                'product_group_read',
                'order_comment_create',
                'product_read_crud_table',
                'brand_read',
                'meta_field_read',
            ],
            5 => [
                'product_read'
            ],
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
