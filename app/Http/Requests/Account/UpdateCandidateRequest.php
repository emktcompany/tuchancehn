<?php

namespace App\Http\Requests\Account;

class UpdateCandidateRequest extends UpdateUserRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && $this->user()->hasRole('candidate');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        return array_merge($rules, [
            'candidate'                  => ['required', 'array'],
            'candidate.gender'           => ['required', 'boolean'],
            'candidate.driver_license'   => ['boolean', 'nullable'],
            'candidate.years_experience' => ['numeric', 'nullable'],
            'candidate.birth'            => ['required', 'date'],
            'candidate.privacy'          => ['boolean', 'nullable'],
            'candidate.subscription'     => ['boolean', 'nullable'],
            'candidate.cv_attachment'    => ['mimes:pdf,doc,docx', 'file'],
        ]);
    }
}
