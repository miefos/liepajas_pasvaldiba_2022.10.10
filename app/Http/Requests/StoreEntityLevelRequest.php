<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEntityLevelRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('entity_level_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:entity_levels'
            ],
            'parent_entity_level_id' => [
                'int',
                'nullable',
                'exists:entity_levels,id',
                'unique:entity_levels,parent_entity_level_id'
            ]
        ];
    }
}
