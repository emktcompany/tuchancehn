<?php

namespace App\Http\Resources;

class SkillResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'is_soft'    => $this->name,
            'created_at' => $this->asDate('created_at'),
        ];
    }
}
