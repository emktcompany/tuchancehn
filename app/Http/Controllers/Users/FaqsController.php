<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqResource;
use App\TuChance\Models\Faq;

class FaqsController extends Controller
{
    /**
     * All countries.
     * @param  \App\TuChance\Models\Faq $categories
     * @return void
     */
    public function index(Faq $categories)
    {
        $rows = $categories
            ->latest()
            ->where('type', request('type', 0) ? 1 : 0)
            ->get();

        return FaqResource::collection($rows);
    }
}
