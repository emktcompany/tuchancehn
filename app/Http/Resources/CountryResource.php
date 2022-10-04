<?php

namespace App\Http\Resources;

class CountryResource extends BaseResource
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
            'id'     => $this->id,
            'code'   => $this->code,
            'name'   => $this->name,
            'abbr'   => $this->abbr,
            'domain' => $this->domain,
            'states' => StateResource::collection($this->whenLoaded('states')),
        ];
    }
}
