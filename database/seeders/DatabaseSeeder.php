<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $email = 'email@email.com';
        $password = 'strongPassword';

        $user = User::create([
            'name'           => 'SuperAdmin',
            'email'          => $email,
            'password'       => bcrypt($password),
        ]);
        $user2 = User::create([
            'name'           => 'Other user',
            'email'          => $email . '2',
            'password'       => bcrypt($password),
        ]);

        \Auth::login($user);

        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,

            EntitiesTableSeeder::class,

            EntityLevelsTableSeeder::class,

            CompleteLevelsTableSeeder::class,

            GoalsTableSeeder::class,

        ]);

        echo "\n\nEmail: $email\n";
        echo "Password: $password\n\n";
    }
}
