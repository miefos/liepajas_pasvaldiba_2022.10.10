<?php

namespace App\Http\Requests;

use App\Rules\ParentGoalEntityShouldBeOneLevelAboveRequestedEntityLevel;
use App\Services\GoalService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Factory;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class StoreGoalRequest extends FormRequest
{
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
