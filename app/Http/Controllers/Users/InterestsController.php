<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\InterestResource;
use App\TuChance\Models\Interest;

class InterestsController extends Controller
{
    /**
     * All countries.
     * @param  \App\TuChance\Models\Interest $categories
     * @return void
     */
    public function index(Interest $categories)
    {
        $rows = $categories
            ->orderBy('name')
            ->get();
        return InterestResource::collection($rows);
    }
}
