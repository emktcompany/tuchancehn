<?php

namespace App\TuChance\Contracts\Repositories;

use Illuminate\Http\Request;

interface Bidders
{
    /**
     * Search bidders
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
     * Find given bidder
     * @param  \Illuminate\Http\Request $id
     * @param  boolean                  $active
     * @return \App\Http\Resources\BidderResource
     */
    public function find($id, $active = true);
}
