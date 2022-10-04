<?php

namespace App\Http\Requests\Admin\EmailTemplates;

use App\Http\Requests\UploadsAttachments;
use Illuminate\Foundation\Http\FormRequest;

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
        $rules = [
            'event'     => ['required', 'string'],
            'days'      => ['required', 'numeric'],
            'title'     => ['required', 'string'],
            'content'   => ['required', 'array'],
            'content.*' => ['required', 'string'],
            'cta'       => ['sometimes', 'string', 'nullable'],
            'cta_text'  => ['sometimes', 'string', 'nullable'],
            'is_active' => ['required', 'string'],
            'link'      => ['string', 'url', 'nullable'],
        ];

        return array_merge(
            $rules,
            $this->cropImage('sponsor'),
            $this->cropImage('banner'),
            $this->cropImage('footer')
        );
    }
}
