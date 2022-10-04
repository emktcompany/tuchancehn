<?php

namespace App\Http\Requests\Account;


class UpdateAdminRequest extends UpdateUserRequest
{

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        $this->validateLocation($rules, null, false);

        return $rules;
    }

}
