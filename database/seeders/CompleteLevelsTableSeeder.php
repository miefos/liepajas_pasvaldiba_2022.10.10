<?php

namespace Database\Seeders;

use App\Models\CompleteLevel;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CompleteLevelsTableSeeder extends Seeder
{
    public function run()
    {
        CompleteLevel::insert([
            ['name' => 'Nav izpildīts', 'value' => 0],
            ['name' => 'Daļēji izpildīts', 'value' => 1],
            ['name' => 'Pilnībā izpildīts', 'value' => 2],
        ]);
    }
}
