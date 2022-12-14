<?php

namespace App\Http\Requests\Admin\Opportunities;

use App\Http\Requests\ValidatesLocation;
use App\Http\Requests\UploadsAttachments;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Exists;

class UpdateRequest extends FormRequest
{
    use UploadsAttachments, ValidatesLocation;

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole([
            'admin', 'bidder',
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name'            => ['required', 'string'],
            'summary'         => ['required', 'string'],
            'description'     => ['required', 'string'],
            'requirements'    => ['string', 'nullable'],
            'characteristics' => ['string', 'nullable'],
            'category_id'     => [
                'required', 'numeric', new Exists('categories', 'id')
            ],
            'begin_at'        => ['date', 'nullable'],
            'finish_at'       => ['date', 'nullable'],
            'allow_apply'     => ['required', 'boolean'],
            'link'            => ['nullable', 'string', 'url'],
            'subcategory_id'  => ['nullable', 'numeric'],
        ];

        if ($this->user()->hasRole('admin')) {
            $rules['is_active'] = [
                'required', 'boolean',
            ];
        }

        $this->validateLocation(
            $rules,
            null,
            $this->user('api')->hasRole('admin')
        );

        if (!$this->user('api')->hasRole('bidder')) {
            $rules['bidder_id'] = [
                'nullable', 'numeric', new Exists('bidders', 'id'),
            ];
        }

        return array_merge($rules, $this->cropImage('image'));
    }
}
