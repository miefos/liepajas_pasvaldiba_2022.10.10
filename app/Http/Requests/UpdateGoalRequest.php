<?php

namespace App\Http\Requests;

use App\Rules\ParentGoalEntityShouldBeOneLevelAboveRequestedEntityLevel;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

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
                'unique:goals,name,' . request()->route('goal')->id,
            ],
            'entity_id' => [
                'exists:entities,id',
                new ParentGoalEntityShouldBeOneLevelAboveRequestedEntityLevel()
            ],
        ];
    }
}
