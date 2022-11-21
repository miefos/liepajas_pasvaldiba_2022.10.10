<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCompleteLevelRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('complete_level_update');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:complete_levels,name,' . request()->route('complete_level')->id,
            ]
        ];
    }
}
