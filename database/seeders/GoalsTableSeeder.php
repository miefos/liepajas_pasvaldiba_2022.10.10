<?php

namespace Database\Seeders;

use App\Models\Entity;
use App\Models\Goal;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Faker\Generator as Faker;

class GoalsTableSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        Goal::withoutGlobalScopes()->insert([
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
            ],
            [
                'name' => 'Celt darbinieku kvalifikāciju',
                'description' => '',
                'complete_level_id' => 1,
                'entity_id' => Entity::where('name', '=', 'IT daļa')->first()->id,
                'parent_goal_id' => 1
            ],[
                'name' => 'Doties 5 pieredzes apmaiņas braucienos',
                'description' => '',
                'complete_level_id' => 1,
                'entity_id' => Entity::where('name', '=', 'IT daļa')->first()->id,
                'parent_goal_id' => 1
            ],[
                'name' => 'Nodrošināt darbinieku labbūtību',
                'description' => '',
                'complete_level_id' => 1,
                'entity_id' => Entity::where('name', '=', 'IT daļa')->first()->id,
                'parent_goal_id' => 1
            ],[
                'name' => 'Izpildīt darbinieku priekšlikumus',
                'description' => '',
                'complete_level_id' => 1,
                'entity_id' => Entity::where('name', '=', 'IT daļa')->first()->id,
                'parent_goal_id' => 1
            ],[
                'name' => 'Piesaistīt 3 jaunus speciālistus',
                'description' => '',
                'complete_level_id' => 1,
                'entity_id' => Entity::where('name', '=', 'IT daļa')->first()->id,
                'parent_goal_id' => 1
            ],[
                'name' => 'Celt darbinieku kvalifikāciju',
                'description' => '',
                'complete_level_id' => 1,
                'entity_id' => Entity::where('name', '=', 'Finanšu pārvalde')->first()->id,
                'parent_goal_id' => 1
            ],[
                'name' => 'Doties 3 pieredzes apmaiņas braucienos',
                'description' => '',
                'complete_level_id' => 1,
                'entity_id' => Entity::where('name', '=', 'Finanšu pārvalde')->first()->id,
                'parent_goal_id' => 1
            ],[
                'name' => 'Celt darbinieku kvalifikāciju',
                'description' => '',
                'complete_level_id' => 1,
                'entity_id' => Entity::where('name', '=', 'Personāla daļa')->first()->id,
                'parent_goal_id' => 1
            ],[
                'name' => 'Celt darbinieku kvalifikāciju',
                'description' => '',
                'complete_level_id' => 1,
                'entity_id' => Entity::where('name', '=', 'IT daļa')->first()->id,
                'parent_goal_id' => 1
            ],[
                'name' => 'Celt darbinieku kvalifikāciju',
                'description' => '',
                'complete_level_id' => 1,
                'entity_id' => Entity::where('name', '=', 'Juridiskā daļa')->first()->id,
                'parent_goal_id' => 1
            ],[
                'name' => 'Celt darbinieku kvalifikāciju',
                'description' => '',
                'complete_level_id' => 1,
                'entity_id' => Entity::where('name', '=', 'Publisko iepirkumu daļa')->first()->id,
                'parent_goal_id' => 1
            ],[
                'name' => 'Celt darbinieku kvalifikāciju',
                'description' => '',
                'complete_level_id' => 1,
                'entity_id' => Entity::where('name', '=', 'Liepājas pārstāvniecība Rīgā')->first()->id,
                'parent_goal_id' => 1
            ],
        ]);

        for ($i = 1; $i < 100; $i++) {
            $user_id = rand(2,25);

            $parentGoals = collect(User::findOrFail($user_id)->entity->goals()->withoutGlobalScopes()->get());

            Goal::withoutGlobalScopes()->insert([
                'name' => 'Mērķis #' . $i,
                'description' => 'Mērķa apraksts',
                'complete_level_id' => rand(1,3),
                'parent_goal_id' => $parentGoals->count() > 0 ? $parentGoals->random()->id : null,
                'user_id' => $user_id
            ]);
        }
    }
}
