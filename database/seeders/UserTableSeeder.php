<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $password = 'password';

        for ($i = 1; $i < 25; $i++) {
            User::create([
                'name' => $faker->name('male'),
                'email' => $faker->email(),
                'password' => bcrypt($password),
                'entity_id' => rand(2, 17)
            ])->assignRole(['Darbinieks']);
        }
    }
}
