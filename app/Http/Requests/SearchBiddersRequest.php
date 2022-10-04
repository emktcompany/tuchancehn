<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchBiddersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'country'  => ['string', 'exists:countries,code'],
            'state_id' => ['numeric', 'exists:states,id'],
            'city_id'  => ['numeric', 'exists:cities,id'],
            'term'     => ['string'],
        ];
    }
}
