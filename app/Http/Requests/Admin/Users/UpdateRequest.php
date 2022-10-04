<?php

namespace App\Http\Requests\Admin\Users;

use App\Http\Requests\Account\UpdateUserRequest;
use App\Http\Requests\UploadsAttachments;

class UpdateRequest extends UpdateUserRequest
{
    use UploadsAttachments;

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasRole('admin');
    }

    /**
     * Get the user id to ignore
     * @var int
     */
    protected function userId () {
        return $this->route('user');
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        $rules['role'] = ['required', 'string', 'in:admin'];

        return array_merge($rules, $this->cropImage('avatar'));
    }
}
