<?php

namespace App\Http\Requests\Admin\Users;

class CreateRequest extends UpdateRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        $rules['password'][] = 'required';

        return $rules;
    }
}
