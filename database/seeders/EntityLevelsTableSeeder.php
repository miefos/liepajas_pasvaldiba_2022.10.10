<?php

namespace Database\Seeders;

use App\Models\EntityLevel;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EntityLevelsTableSeeder extends Seeder
{
    public function run()
    {
        EntityLevel::insert([
            ['name' => 'Organizācija', 'parent_entity_level_id' => null],
            ['name' => 'Struktūrvienība', 'parent_entity_level_id' => 1],
            ['name' => 'Darbinieks', 'parent_entity_level_id' => 2],
        ]);
    }
}
