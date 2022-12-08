<?php

namespace App\Http\Requests;

use App\Models\Goal;
use App\Rules\ParentGoalEntityShouldBeOneLevelAboveRequestedEntityLevel;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateGoalRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('goal_update');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'complete_level_id' => [
                'required',
                'exists:complete_levels,id'
            ],
            'parent_goal_id' => [
                'nullable',
                'exists:goals,id',
                new ParentGoalEntityShouldBeOneLevelAboveRequestedEntityLevel()
            ],
            'entity_id' => [
                'nullable',
                'exists:entities,id',
                'required_without:user_id',
                new ParentGoalEntityShouldBeOneLevelAboveRequestedEntityLevel()
            ],
            'user_id' => [
                'nullable',
                'exists:users,id',
                new ParentGoalEntityShouldBeOneLevelAboveRequestedEntityLevel()
            ],
        ];
    }

    public function messages()
    {
        return [
            "name" => "Ievadiet mērķa nosaukumu.",
            "complete_level_id" => "Norādiet mērķa pabeigtības līmeni.",
            "entity_id.required_without" => "Norādiet mērķa īpašnieku",
            "user_id.required_without" => "Norādiet mērķa īpašnieku",
        ];
    }
}
