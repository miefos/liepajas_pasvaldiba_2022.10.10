<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEntityRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('entity_update');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:entities,name,' . request()->route('entity')->id,
            ],
            'entity_level_id' => [
                'int',
                'required',
                'exists:entity_levels,id'
            ],
            'supervisor_id' => [
                'int',
                'required',
                'exists:users,id'
            ],
        ];
    }
}
