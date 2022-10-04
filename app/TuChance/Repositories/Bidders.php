<?php

namespace App\TuChance\Repositories;

use App\Http\Resources\BidderResource;
use App\TuChance\Contracts\Repositories\Bidders as BiddersContract;
use App\TuChance\Models\Bidder;
use Illuminate\Http\Request;

class Bidders implements BiddersContract
{
    /**
     * Bidder model
     * @var \App\TuChance\Models\Bidder
     */
    protected $bidders;

    /**
     * Create a new AuthController instance.
     * @param  \App\TuChance\Models\Bidder $bidders
     * @return void
     */
    public function __construct(Bidder $bidders)
    {
        $this->bidders = $bidders;
    }

    /**
     * Featured bidders
     * @return \App\Http\Resources\ResourceCollection
     */
    public function featured()
    {
        $bidders = $this->baseQuery(true)
            ->where('is_featured', 1)
            ->whereHas('opportunities', function ($query) {
                $query->where('is_active', 1)
                    ->available();
            })
            ->latest()
            ->with([
                'opportunities' => function ($query) {
                    $query->where('is_active', 1)
                        ->available();
                },
                'opportunities.city', 'opportunities.state',
                'opportunities.country', 'opportunities.image',
                'opportunities.skills',
            ])
            ->take(2)
            ->get();

        $bidders->each(function ($bidder) {
            $bidder->opportunities
                ->each(function ($opportunity) use ($bidder) {
                    $bidder = clone $bidder;
                    $bidder->unsetRelation('opportunities');

                    $opportunity->bidder()
                        ->associate($bidder);
                });
        });

        return BidderResource::collection($bidders);
    }

    /**
     * Search bidders
     * @param  \Illuminate\Http\Request $terms
     * @param  boolean                  $active
     * @param  int                      $per_page
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function search(
        Request $terms = null,
        $active = true,
        $per_page = 12
    ) {
        $query = $this->baseQuery($active);

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

            if ($terms->has('term')) {
                $query->search($terms->get('term'), null, true, true);
            } else {
                $query->latest();
            }
        }

        return BidderResource::collection($query->paginate($per_page));
    }

    /**
     * Find given bidder
     * @param  \Illuminate\Http\Request $id
     * @param  boolean                  $active
     * @return \App\Http\Resources\BidderResource
     */
    public function find($id, $active = true)
    {
        $query = $this->baseQuery($active);
        $query->where('slug', $id);
        return new BidderResource($query->firstOrFail());
    }

    /**
     * Create a base query builder object
     * @param  boolean|null $active
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function baseQuery($active)
    {
        $relations = ['city', 'state', 'country', 'image', 'user.avatar'];

        $query = $this->bidders
            ->with($relations);

        if (is_null($active)) {
            // include all
        } elseif ($active) {
            $query->where('is_active', '=', 1);
        } else {
            $query->where('is_active', '=', 0);
        }

        return $query;
    }
}
