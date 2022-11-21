<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCompleteLevelRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('complete_level_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:complete_levels'
            ]
        ];
    }
}
