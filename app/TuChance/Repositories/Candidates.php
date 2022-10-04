<?php

namespace App\TuChance\Repositories;

use App\Http\Resources\CandidateResource;
use App\TuChance\Contracts\Repositories\Candidates as CandidatesContract;
use App\TuChance\Models\Candidate;
use Illuminate\Http\Request;

class Candidates implements CandidatesContract
{
    /**
     * Candidate model
     * @var \App\TuChance\Models\Candidate
     */
    protected $candidates;

    /**
     * Create a new AuthController instance.
     * @param  \App\TuChance\Models\Candidate $candidates
     * @return void
     */
    public function __construct(Candidate $candidates)
    {
        $this->candidates = $candidates;
    }

    /**
     * Search candidates
     * @param  \Illuminate\Http\Request $terms
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function search(Request $terms = null)
    {
        $query = $this->baseQuery();

        if ($terms) {
            if ($terms->has('country')) {
                $query->byCountry($terms->get('country'));
            }

            if ($terms->has('country_id')) {
                $query->where('country_id', $terms->get('country_id'));
            }

            if ($terms->has('state_id')) {
                $query->where('state_id', $terms->get('state_id'));
            }

            if ($terms->has('city_id')) {
                $query->where('city_id', $terms->get('city_id'));
            }

            if ($terms->has('gender')) {
                $query->where('gender', $terms->get('gender'));
            }

            if ($terms->has('age_range')) {
                $query->where('age_range', $terms->get('age_range'));
            }

            if ($terms->has('term')) {
                $query->search($terms->get('term'), null, true, true);
            } else {
                $query->latest();
            }
        }

        return CandidateResource::collection($query->paginate(10));
    }

    /**
     * Find given candidate
     * @param  \Illuminate\Http\Request $id
     * @param  boolean                  $active
     * @return \App\Http\Resources\CandidateResource
     */
    public function find($id)
    {
        $query = $this->baseQuery();
        return new CandidateResource($query->findOrFail($id));
    }

    /**
     * Create a base query builder object
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function baseQuery()
    {
        $query = $this->candidates
            ->with('city', 'state', 'country', 'user.avatar', 'skills');

        return $query;
    }
}
