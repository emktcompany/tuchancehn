<?php

namespace App\Http\Resources;

class TestimonialResource extends BaseResource
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
            'id'          => $this->id,
            'name'        => $this->name,
            'body'        => $this->body,
            'is_active'   => $this->is_active,
            'created_at'  => $this->asDate('created_at'),
            'image'       => new AssetResource($this->whenLoaded('image')),
        ];
    }
}
