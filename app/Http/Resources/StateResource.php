<?php

namespace App\Http\Resources;

class StateResource extends BaseResource
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
            'country_id' => $this->country_id,
            'cities'     => CityResource::collection($this->whenLoaded('cities')),
        ];
    }
}
