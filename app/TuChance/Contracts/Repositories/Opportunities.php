<?php

namespace App\TuChance\Contracts\Repositories;

use Illuminate\Http\Request;

interface Opportunities
{
    /**
     * Search opportunities
     * @param  \Illuminate\Http\Request $query
     * @param  boolean                  $active
     * @param  int                      $per_page
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function search(
        Request $query = null,
        $active = true,
        $per_page = 12
    );

    /**
     * Find given opportunity
     * @param  \Illuminate\Http\Request $id
     * @param  boolean                  $active
     * @return \App\Http\Resources\OpportunityResource
     */
    public function find($id, $active = true);

    /**
     * View active opportunities the candidate has enrolled to
     * @param  int  $candidate_id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function enrolled($candidate_id);
}
