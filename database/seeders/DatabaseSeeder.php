<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $superadminEmail = 'superadmin@email.com';
        $password = 'password';

        $user = User::create([
            'name'           => 'SuperAdmin',
            'email'          => $superadminEmail,
            'password'       => bcrypt($password),
        ]);
        $user2 = User::create([
            'name'           => 'User',
            'email'          => 'user@email.com',
            'password'       => bcrypt($password),
        ]);

        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            RoleUserTableSeeder::class,
            EntitiesTableSeeder::class,
            EntityLevelsTableSeeder::class,
            CompleteLevelsTableSeeder::class,
            GoalsTableSeeder::class,
        ]);

        echo "\n\nEmail: $superadminEmail\n";
        echo "Password: $password\n\n";
    }
}
