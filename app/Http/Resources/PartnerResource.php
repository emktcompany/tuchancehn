<?php

namespace App\Http\Resources;

class PartnerResource extends BaseResource
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
            'link'        => $this->link,
            'type'        => $this->type,
            'is_active'   => $this->is_active,
            'created_at'  => $this->asDate('created_at'),
            'image'       => new AssetResource($this->whenLoaded('image')),
        ];
    }
}
