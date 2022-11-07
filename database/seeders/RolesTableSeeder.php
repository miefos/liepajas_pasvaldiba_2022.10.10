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
                'name' => 'Darbinieks',
            ],
        ];

        \Spatie\Permission\Models\Role::insert($roles);
    }
}
