<?php

namespace App\Http\Resources;

class FaqResource extends BaseResource
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
            'question'   => $this->question,
            'answer'     => $this->answer,
            'type'       => $this->type,
            'is_active'  => $this->is_active,
            'created_at' => $this->asDate('created_at'),
        ];
    }
}
