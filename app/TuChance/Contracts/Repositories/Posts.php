<?php

namespace App\TuChance\Contracts\Repositories;

use Illuminate\Http\Request;

interface Posts
{
    /**
     * Search posts
     * @param  \Illuminate\Http\Request $query
     * @param  boolean                  $active
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function search(Request $query, $active = true);

    /**
     * Find given post
     * @param  \Illuminate\Http\Request $id
     * @param  boolean                  $active
     * @return \App\Http\Resources\PostResource
     */
    public function find($id, $active = true);
}
