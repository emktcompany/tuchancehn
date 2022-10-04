<?php

namespace App\TuChance\Contracts\Repositories;

use Illuminate\Http\Request;

interface Candidates
{
    /**
     * Search candidates
     * @param  \Illuminate\Http\Request $query
     * @param  boolean                  $active
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function search(Request $query);

    /**
     * Find given candidate
     * @param  \Illuminate\Http\Request $id
     * @param  boolean                  $active
     * @return \App\Http\Resources\CandidateResource
     */
    public function find($id);
}
