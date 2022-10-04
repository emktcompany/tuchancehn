<?php

namespace App\Http\Requests;

trait UploadsAttachments
{
    /**
     * Build crop image rule
     * @param  string  $relation
     * @param  boolean $required
     * @return array
     */
    public function cropImage($relation, $required = false)
    {
        $rules = [
            "{$relation}_crop"        => ['array'],
            "{$relation}_crop.file"   => ['image'],
            "{$relation}_crop.x"      => ['numeric'],
            "{$relation}_crop.y"      => ['numeric'],
            "{$relation}_crop.width"  => ['numeric'],
            "{$relation}_crop.height" => ['numeric'],
        ];

        if ($required) {
            $rules = collect($rules)->map(function ($rule) {
                array_push($rule, 'required');
                return $rule;
            })->toArray();
        }

        return $rules;
    }
}
