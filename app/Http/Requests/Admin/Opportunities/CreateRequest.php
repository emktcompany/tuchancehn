<?php

namespace App\Http\Requests\Admin\Opportunities;

class CreateRequest extends UpdateRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return parent::rules();
    }
}
