<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEntityRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('entity_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:entities'
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
