<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdatePermissionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('permission_update');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:permissions,name,' . request()->route('permission')->id,
            ],
        ];
    }
}
