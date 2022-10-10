<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    public function run()
    {
        User::findOrFail(1)->syncRoles(1);
//        User::findOrFail(2)->syncRoles(2);
//        User::findOrFail(3)->syncRoles(3);
//        User::findOrFail(4)->syncRoles(4);
//        User::findOrFail(5)->syncRoles(5);
//
//        User::findOrFail(6)->syncRoles(1);
//        User::findOrFail(7)->syncRoles(2);
//        User::findOrFail(8)->syncRoles(3);
//        User::findOrFail(9)->syncRoles(4);
//        User::findOrFail(10)->syncRoles(5);
    }
}
