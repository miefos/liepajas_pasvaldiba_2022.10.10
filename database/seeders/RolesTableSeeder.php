<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'id'    => 1,
                'name' => 'Super Admin',
            ],
            [
                'id'    => 2,
                'name' => 'Admin',
            ],
            [
                'id'    => 3,
                'name' => 'Role X',
            ],
            [
                'id'    => 4,
                'name' => 'Role Y',
            ],
            [
                'id'    => 5,
                'name' => 'Darbinieks',
            ],
        ];

        \Spatie\Permission\Models\Role::insert($roles);
    }
}
