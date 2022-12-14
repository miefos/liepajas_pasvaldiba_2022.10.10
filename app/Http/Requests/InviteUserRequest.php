<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class InviteUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('user_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => [
                'required',
                'email',
                'unique:users',
            ],
            'roles.*' => [
                'integer',
                'exists:roles,id'
            ],
            'roles' => [
                'nullable',
                'array',
            ],
            'entity_id' => [
                'exists:entities,id',
            ],
        ];
    }
}
