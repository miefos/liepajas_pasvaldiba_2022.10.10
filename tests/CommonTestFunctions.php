<?php

namespace Tests;

use App\Models\Entity;
use App\Models\Goal;
use App\Models\User;
use Database\Seeders\CompleteLevelsTableSeeder;
use Database\Seeders\EntitiesTableSeeder;
use Database\Seeders\EntityLevelsTableSeeder;
use Database\Seeders\PermissionRoleTableSeeder;
use Database\Seeders\PermissionsTableSeeder;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Support\Facades\Artisan;

trait CommonTestFunctions
{
    public function seedBasicAndCreateAdmin()
    {
        // drop all existing data from db
        Artisan::call('migrate:fresh');

        // first seed
        $this->seed([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class
        ]);

        // create user
        $userName = 'testUser';
        $user = $this->createUser($userName, ['Admin']);

        // second seed
        $this->seed([
            EntityLevelsTableSeeder::class,
            CompleteLevelsTableSeeder::class,
            EntitiesTableSeeder::class,
        ]);

        return $user;
    }

    public function createUser($name, $roles = []) {
        $user = User::create([
            'email' => "$name@$name.$name",
            'name' => $name,
            'password' => bcrypt("$name")
        ])->syncRoles($roles);

        $user->email_verified_at = now();

        return $user;
    }

    public function seedFiveOrganizationsGoals() {
        Goal::insert([
            [
                'name' => 'Profesionāli darbinieki',
                'description' => 'Mērķtiecīgi pilnveidot darbinieku prasmes un motivāciju',
                'complete_level_id' => 1,
                'entity_id' => 1,
                'parent_goal_id' => null
            ],[
                'name' => 'Kvalitatīvi pakalpojumi',
                'description' => 'Stiprināt un attīstīt starpinstitucionālu sadarbību',
                'complete_level_id' => 1,
                'entity_id' => 1,
                'parent_goal_id' => null
            ],[
                'name' => 'Digitālā transformācija',
                'description' => 'Nodrošināt pārvaldības digitalizāciju un e-pakalpojumu attīstību',
                'complete_level_id' => 1,
                'entity_id' => 1,
                'parent_goal_id' => null
            ],[
                'name' => 'Sabiedrības iesaiste',
                'description' => 'Nodrošināt sabiedrības un uzņēmēju iesaisti un līdzdalību pašvaldības attīstībā',
                'complete_level_id' => 1,
                'entity_id' => 1,
                'parent_goal_id' => null
            ],[
                'name' => 'Pilsētas tēls',
                'description' => 'Popularizēt Liepājas pilsētas tēlu biznesam, dzīvošanai, atpūtai un tūrismam',
                'complete_level_id' => 1,
                'entity_id' => 1,
                'parent_goal_id' => null
            ]
        ]);
    }
}
