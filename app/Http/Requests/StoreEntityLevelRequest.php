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
            ],
            'show_to_all' => [
                'required',
                'boolean'
            ],
            'employee_level' => [
                'required',
                'boolean'
            ],
            'show_to_direct_descendant' => [
                'required',
                'boolean'
            ],
            'show_to_descendants' => [
                'required',
                'boolean'
            ],
        ];
    }
}
