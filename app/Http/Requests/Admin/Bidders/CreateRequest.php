<?php

namespace App\Http\Requests\Admin\Bidders;

class CreateRequest extends UpdateRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        $rules['user.password'][] = 'required';

        return $rules;
    }
}
