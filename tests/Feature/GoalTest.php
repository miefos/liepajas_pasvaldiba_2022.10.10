<?php

namespace Tests\Feature;

use App\Models\Entity;
use App\Models\EntityLevel;
use App\Models\Goal;
use Tests\CommonTestFunctions;
use Tests\TestCase;

class GoalTest extends TestCase
{
    use CommonTestFunctions;

    public function test_seed_is_ok()
    {
        $user = $this->seedBasicAndCreateAdmin();
        $this->assertGuest();

        $this->assertEquals(17, Entity::all()->count());

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);

        // check entities
        $this->assertEquals(17, $user->supervisedEntities()->get()->count());
        $this->assertEquals(1, EntityLevel::findOrFail(1)->entities()->count());
        $this->assertEquals(16, EntityLevel::findOrFail(2)->entities()->count());
        $this->assertEquals(0, EntityLevel::findOrFail(3)->entities()->count());
    }

    public function test_goals_read_authorization() {
        $userAdmin = $this->seedBasicAndCreateAdmin();

        $response = $this->actingAs($userAdmin)->get('/');
        $response->assertStatus(200);

        $this->seedFiveOrganizationsGoals();

        $this->assertEquals(5, Goal::all()->count());

        $departmentIT = Entity::where("name", "=", "IT daļa")->firstOrFail();
        $dataSecurityEntity = Entity::where("name", "=", "Datu aizsardzības daļa")->firstOrfail();
        foreach([$departmentIT, $dataSecurityEntity] as $entity) {
            Goal::insert([
                [
                    'name' => $entity->name . " Mērķis #1",
                    'complete_level_id' => 1,
                    'entity_id' => $entity->id,
                    'parent_goal_id' => 1
                ], [
                    'name' => $entity->name . " Mērķis #2",
                    'complete_level_id' => 1,
                    'entity_id' => $entity->id,
                    'parent_goal_id' => 1
                ], [
                    'name' => $entity->name . " Mērķis #3",
                    'complete_level_id' => 3,
                    'entity_id' => $entity->id,
                    'parent_goal_id' => 2
                ], [
                    'name' => $entity->name . " Mērķis #4",
                    'complete_level_id' => 2,
                    'entity_id' => $entity->id,
                    'parent_goal_id' => 3
                ],
            ]);
        }

//        $this->assertEquals(13, Goal::all()->count());
        $userITSupervisor = $this->createUser('Supervisor IT', ['Darbinieks']);

    }
}
