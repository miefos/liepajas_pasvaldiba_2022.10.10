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
            ['name' => 'Organizācija', 'parent_entity_level_id' => null, 'show_to_all' => true, 'show_to_descendants' => true, 'show_to_direct_descendant' => true],
        ]);
        EntityLevel::insert([
            ['name' => 'Struktūrvienība', 'parent_entity_level_id' => 1, 'show_to_direct_descendant' => true],
        ]);
        EntityLevel::insert([
            ['name' => 'Darbinieks', 'parent_entity_level_id' => 2, 'employee_level' => true],
        ]);
    }
}
