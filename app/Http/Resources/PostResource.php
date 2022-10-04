<?php

namespace App\Http\Resources;

class PostResource extends BaseResource
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
            'slug'       => $this->slug,
            'summary'    => $this->summary,
            'content'    => $this->content,
            'is_active'  => $this->is_active,
            'user_id'    => $this->user_id,
            'created_at' => $this->asDate('created_at'),
            'image'      => new AssetResource($this->whenLoaded('image')),
            'user'       => new UserResource($this->whenLoaded('user')),
        ];
    }
}
