<?php

namespace Database\Seeders;

use App\Models\Entity;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EntitiesTableSeeder extends Seeder
{
    public function run()
    {
        Entity::insert([
            [
                'name' => 'Liepājas pašvaldība',
                'entity_level_id' => 1,
                'supervisor_id' => 1,
                'parent_entity_id' => null,
                'is_root_node' => true,
            ],[
                'name' => 'Personāla daļa',
                'entity_level_id' => 2,
                'supervisor_id' => 1,
                'parent_entity_id' => 1,
                'is_root_node' => false,
            ],[
                'name' => 'Juridiskā daļa',
                'entity_level_id' => 2,
                'supervisor_id' => 1,
                'parent_entity_id' => 1,
                'is_root_node' => false,
            ],[
                'name' => 'Publisko iepirkumu daļa',
                'entity_level_id' => 2,
                'supervisor_id' => 1,
                'parent_entity_id' => 1,
                'is_root_node' => false,
            ],[
                'name' => 'Liepājas pārstāvniecība Rīgā',
                'entity_level_id' => 2,
                'supervisor_id' => 1,
                'parent_entity_id' => 1,
                'is_root_node' => false,
            ],[
                'name' => 'Finanšu pārvalde',
                'entity_level_id' => 2,
                'supervisor_id' => 1,
                'parent_entity_id' => 1,
                'is_root_node' => false,
            ],[
                'name' => 'Kapitālsabiedrību pārvaldības uzraudzības un revīzijas daļa',
                'entity_level_id' => 2,
                'supervisor_id' => 1,
                'parent_entity_id' => 1,
                'is_root_node' => false,
            ],[
                'name' => 'Datu aizsardzības daļa',
                'entity_level_id' => 2,
                'supervisor_id' => 1,
                'parent_entity_id' => 1,
                'is_root_node' => false,
            ],[
                'name' => 'Organizatoriskā daļa',
                'entity_level_id' => 2,
                'supervisor_id' => 1,
                'parent_entity_id' => 1,
                'is_root_node' => false,
            ],[
                'name' => 'Ēku apsaimniekošanas un saimniecības daļa',
                'entity_level_id' => 2,
                'supervisor_id' => 1,
                'parent_entity_id' => 1,
                'is_root_node' => false,
            ],[
                'name' => 'Klientu apkalpošanas un pakalpojumu centrs',
                'entity_level_id' => 2,
                'supervisor_id' => 1,
                'parent_entity_id' => 1,
                'is_root_node' => false,
            ],[
                'name' => 'Domes priekšsēdētāja birojs',
                'entity_level_id' => 2,
                'supervisor_id' => 1,
                'parent_entity_id' => 1,
                'is_root_node' => false,
            ],[
                'name' => 'Attīstības pārvalde',
                'entity_level_id' => 2,
                'supervisor_id' => 1,
                'parent_entity_id' => 1,
                'is_root_node' => false,
            ],[
                'name' => 'Izpilddirektora birojs',
                'entity_level_id' => 2,
                'supervisor_id' => 1,
                'parent_entity_id' => 1,
                'is_root_node' => false,
            ],[
                'name' => 'Sabiedrisko attiecību un mārketinga daļa',
                'entity_level_id' => 2,
                'supervisor_id' => 1,
                'parent_entity_id' => 1,
                'is_root_node' => false,
            ],[
                'name' => 'IT daļa',
                'entity_level_id' => 2,
                'supervisor_id' => 1,
                'parent_entity_id' => 1,
                'is_root_node' => false,
            ],[
                'name' => 'Vides, veselības un sabiedrības līdzdalības daļa',
                'entity_level_id' => 2,
                'supervisor_id' => 1,
                'parent_entity_id' => 1,
                'is_root_node' => false,
            ],
        ]);
    }
}
