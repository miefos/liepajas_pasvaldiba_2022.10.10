<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateRoleRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('role_update');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:roles,name,' . request()->route('role')->id,
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
