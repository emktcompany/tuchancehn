<?php

namespace App\Http\Resources;

class CategoryResource extends BaseResource
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
            'id'            => $this->id,
            'name'          => $this->name,
            'slug'          => $this->slug,
            'title'         => $this->title,
            'description'   => $this->description,
            'color'         => $this->color,
            'link'          => $this->link,
            'is_active'     => $this->is_active,
            'created_at'    => $this->asDate('created_at'),
            'image'         => new AssetResource($this->whenLoaded('image')),
            'banner'        => new AssetResource($this->whenLoaded('banner')),
            'opportunity'   => new AssetResource($this->whenLoaded('opportunity')),
            'subcategories' => SubCategoryResource::collection($this->whenLoaded('subcategories', function () {
                return $this->subcategories->sortBy('weight');
            })),
        ];
    }
}
