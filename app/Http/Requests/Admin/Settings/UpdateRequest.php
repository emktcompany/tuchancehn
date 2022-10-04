<?php

namespace App\Http\Requests\Admin\Settings;

use App\Http\Requests\UploadsAttachments;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Exists;

class UpdateRequest extends FormRequest
{
    use UploadsAttachments;

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole([
            'admin',
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'value' => ['required'],
        ];
    }
}
