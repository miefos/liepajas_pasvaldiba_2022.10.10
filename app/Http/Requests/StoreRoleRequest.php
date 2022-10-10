<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('role_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:roles'
            ],
            'permissions.*' => [
                'integer',
                'exists:permissions,id'
            ],
            'permissions' => [
                'nullable',
                'array',
            ],
        ];
    }
}
