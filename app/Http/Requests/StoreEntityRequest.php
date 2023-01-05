<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

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
            'is_root_node' => [ // this makes sure that there exists only one row with `is_root_node` set to true (1).
                Rule::unique('entities', 'is_root_node')
                    ->where(static function ($query) {
                        return $query->where('is_root_node', '!=', 0);
                    })
            ]
        ];
    }
}
