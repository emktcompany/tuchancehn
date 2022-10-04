<?php

namespace App\Http\Resources;

class UserResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = $request->user();

        return [
            'id'            => $this->id,
            'email'         => $this->email,
            'name'          => $this->name,
            'first_name'    => head(explode(' ', $this->name)),
            'last_name'     => last(explode(' ', $this->name, 2)),
            'name'          => $this->name,
            'is_active'     => $this->is_active,
            'country_id'    => $this->country_id,
            'state_id'      => $this->state_id,
            'city_id'       => $this->city_id,
            'last_login_at' => $this->asDate('last_login_at'),
            'login_at'      => $this->asDate('login_at'),
            'created_at'    => $this->asDate('created_at'),
            'bidder'        => new BidderResource($this->whenLoaded('bidder')),
            'candidate'     => new CandidateResource($this->whenLoaded('candidate')),
            $this->mergeWhen($this->resource->relationLoaded('tags'), [
                'tag_ids' => $this->tags->pluck('id'),
                'tags'    => InterestResource::collection($this->tags),
            ]),
            'role'          => $this->resource->getRoleNames()->first(),
            'roles'         => $this->resource->getRoleNames(),
            'avatar'        => new AssetResource($this->whenLoaded('avatar')),
            'country'       => new CountryResource($this->whenLoaded('country')),
            'city'          => new CityResource($this->whenLoaded('city')),
            'state'         => new StateResource($this->whenLoaded('state')),
        ];
    }
}
