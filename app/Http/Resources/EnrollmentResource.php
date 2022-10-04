<?php

namespace App\Http\Resources;

class EnrollmentResource extends BaseResource
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
            'likeness'      => $this->when(
                $this->resource->relationLoaded('candidate') &&
                $this->resource->relationLoaded('opportunity'),
                function () {
                    $candidate   = $this->candidate;
                    $opportunity = $this->opportunity;

                    $candidate_skills   = $candidate->skills->pluck('id');
                    $opportunity_skills = $opportunity->skills->pluck('id');

                    if (!$opportunity_skills->count()) {
                        return 1;
                    }

                    $diff = $opportunity_skills->intersect($candidate_skills);
                    return $diff->count() / $opportunity_skills->count();
                }
            ),
            'is_accepted'   => $this->is_accepted,
            'is_fullfilled' => $this->is_fullfilled,
            'candidate'     => new CandidateResource($this->whenLoaded('candidate')),
            'opportunity'   => new OpportunityResource($this->whenLoaded('opportunity')),
            'created_at'    => $this->asDate('created_at'),
        ];
    }
}
