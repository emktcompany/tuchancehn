<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchBiddersRequest;
use App\Http\Resources\BidderResource;
use App\TuChance\Contracts\Repositories\Bidders;

class BiddersController extends Controller
{
    /**
     * Bidder model
     * @var \App\TuChance\Contracts\Repositories\Bidders
     */
    protected $bidders;

    /**
     * Create a new controller instance
     * @param  \App\TuChance\Contracts\Repositories\Bidders $bidders
     * @return void
     */
    public function __construct(Bidders $bidders)
    {
        $this->bidders = $bidders;
    }

    /**
     * Get featured bidders and their opportunities
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function featured()
    {
        return $this->bidders->featured();
    }

    /**
     * Search bidders
     * @param  \App\Http\Requests\SearchBiddersRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(SearchBiddersRequest $request)
    {
        return $this->bidders->search($request);
    }

    /**
     * Show bidder
     * @param  int $id
     * @return \App\Http\Resources\BidderResource
     */
    public function show($id)
    {
        return $this->bidders->find($id);
    }
}
