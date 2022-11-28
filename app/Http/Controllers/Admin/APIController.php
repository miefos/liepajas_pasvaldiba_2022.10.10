<?php

namespace App\Http\Controllers\Admin;

use App\Models\Entity;
use App\Models\Goal;
use App\Models\User;
use Inertia\Inertia;

class APIController
{
    /**
     * @param $owner_type - two possible values - "entity" or "user"
     * @param $id - id of the entity or of the user
     * @return string[]
     */
    public function getAvailableGoals($owner_type, $id) {
        $id = intval($id);
        if ($owner_type === 'user') {
            $user = User::findOrFail($id);
            $availableGoals = $user->entity?->goals()->with('entity')->get();

            return ['status' => 'OK', 'data' => $availableGoals];
        } else if ($owner_type === 'entity') {
            $entity = Entity::findOrFail($id);
            $availableGoals = $entity->parentEntity?->goals()->with('entity')->get();
            return ['status' => 'OK', 'data' => $availableGoals];
        } else {
            return ['status' => 'ERR'];
        }
    }
}
