<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEntityLevelRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('entity_level_update');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:entity_levels,name,' . request()->route('entity_level')->id,
            ],
            'parent_entity_level_id' => [
                'int',
                'nullable',
                'exists:entity_levels,id',
                'unique:entity_levels,parent_entity_level_id,' . request()->route('entity_level')->id,
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
