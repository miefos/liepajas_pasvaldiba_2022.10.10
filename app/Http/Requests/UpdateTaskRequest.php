<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('task_update');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'goal_id' => [
                'nullable',
                'exists:goals,id'
            ],
            'date' => [
                'required',
                'date'
            ]
        ];
    }
}
