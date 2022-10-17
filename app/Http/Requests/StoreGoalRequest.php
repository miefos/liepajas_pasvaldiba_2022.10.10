<?php

namespace App\Http\Requests;

use App\Models\Entity;
use App\Models\Goal;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Factory;

class StoreGoalRequest extends FormRequest
{
    public function __construct(Factory $validationFactory)
    {
        $validationFactory->extend(
            'parent_goal_entity_id_should_match_requested_entity_match',
            function ($attribute, $value, $parameters) {
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
            },
            'Šī struktūrvienība šim virsmērķim nav atbilstoša!'
        );
    }

    public function authorize()
    {
        return Gate::allows('goal_create');
            }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:goals'
            ],
            'entity_id' => [
                'exists:entities,id',
                'parent_goal_entity_id_should_match_requested_entity_match'
            ],
        ];
    }
}
