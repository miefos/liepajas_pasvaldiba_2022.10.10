<?php

namespace App\Rules;

use App\Models\Entity;
use App\Models\Goal;
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
        $requestedEntity = Entity::with('entityLevel', 'entityLevel.parentEntityLevel')->find($requestedEntityId);
        $requestedEntityLevelId = $requestedEntity->entityLevel->id;

        $parentGoalId = intval(request()->get('parent_goal_id'));
        $parentGoal = Goal::with('entity', 'entity.entityLevel', 'entity.entityLevel.subEntityLevels')->find($parentGoalId);

        if (!$requestedEntity->entityLevel->parentEntityLevel) { // if it is the first structural level
            if ($parentGoal) { // no parent goal should be set
                return false;
            } else {
                return true;
            }
        }

        if (!$parentGoal) return false;
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
        return 'Šī struktūrvienība šim virsmērķim nav atbilstoša.';
    }
}
