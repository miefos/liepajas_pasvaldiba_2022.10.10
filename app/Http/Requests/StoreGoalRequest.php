<?php

namespace App\Http\Requests;

use App\Models\Entity;
use App\Models\Goal;
use App\Rules\ParentGoalEntityShouldBeOneLevelAboveRequestedEntityLevel;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Factory;

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
                'unique:goals'
            ],
            'entity_id' => [
                'nullable',
                'exists:entities,id',
                new ParentGoalEntityShouldBeOneLevelAboveRequestedEntityLevel()
            ],
        ];
    }
}
