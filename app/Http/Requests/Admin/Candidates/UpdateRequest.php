<?php

namespace App\Http\Requests\Admin\Candidates;

use App\Http\Requests\Account\UpdateCandidateRequest;
use App\Http\Requests\UploadsAttachments;
use App\Http\Requests\ValidatesLocation;
use App\TuChance\Models\Candidate;
use Illuminate\Validation\Rules\Unique;

class UpdateRequest extends UpdateCandidateRequest
{
    use UploadsAttachments, ValidatesLocation;

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
     * Unique email rule definition
     * @return \Illuminate\Validation\Rules\Unique
     */
    protected function userId()
    {
        return with(new Candidate)
            ->join('users', function ($join) {
                $join->on('candidates.user_id', '=', 'users.id');
            })
            ->where('candidates.id', $this->route('candidate'))
            ->get(['users.id'])
            ->pluck('id')
            ->first();
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        $rules = collect(parent::rules());

        $keys = $rules->keys()->map(function ($key) {
            if (starts_with($key, 'candidate.')) {
                return preg_replace('/^candidate./', '', $key);
            }

            if (starts_with($key, 'avatar_')) {
                return $key;
            }

            return "user.{$key}";
        });

        $rules = array_combine($keys->all(), $rules->values()->all());

        $rules['user'] = $rules['user.candidate'];

        unset($rules['user.candidate']);

        $rules['user.is_active'] = [
            'required', 'boolean',
        ];

        $this->validateLocation(
            $rules,
            'user',
            $this->user('api')->hasRole('admin')
        );

        return $rules;
    }
}
