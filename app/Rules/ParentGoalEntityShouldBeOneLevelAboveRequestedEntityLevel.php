<?php

namespace App\Rules;

use App\Models\Entity;
use App\Models\EntityLevel;
use App\Models\Goal;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class ParentGoalEntityShouldBeOneLevelAboveRequestedEntityLevel implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $requestedEntityId = intval(request()->get('entity_id'));
        $requestedUserId = intval(request()->get('user_id'));
        $requestedEntity = Entity::with('entityLevel', 'entityLevel.parentEntityLevel')->find($requestedEntityId);
        $requestedUser = User::with('entity')->find($requestedUserId);

        $parentGoalId = intval(request()->get('parent_goal_id'));
        $parentGoal = Goal::with('entity', 'entity.entityLevel', 'entity.entityLevel.subEntityLevels')->find($parentGoalId);

        if ($requestedEntity && $requestedUser) return false; // the goal cannot be owned by both - user and entity
        if (!$requestedEntity && !$requestedUser) return false; // the goal cannot be owned by neither user nor entity

        $requestedEntityLevelId = $requestedEntity ? $requestedEntity->entityLevel->id : EntityLevel::employeeLevel()->first()->id;

        if (!$parentGoal) {
                return $requestedEntity && !$requestedEntity->entityLevel->parentEntityLevel; // if parent goal is not set, only way that it is ok if the entity level is first
        }

        $allowedSubEntityLevels = $parentGoal->entity->entityLevel->subEntityLevels;
        $allowedEntityLevelIds = $allowedSubEntityLevels->pluck('id');

        return $allowedEntityLevelIds->contains($requestedEntityLevelId);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Šis mērķa īpašnieks (vienība / darbinieks) nav kombinējams ar šo virsmērķi.';
    }
}
