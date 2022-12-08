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
                'unique:tasks,name,' . request()->route('task')->id,
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
