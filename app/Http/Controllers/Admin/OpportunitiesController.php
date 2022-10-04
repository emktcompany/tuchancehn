<?php

namespace App\Http\Controllers\Admin;

use App\Events\OpportunityCreated;
use App\Exports\BaseExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ImportRequest;
use App\Http\Requests\Admin\Opportunities\CreateRequest;
use App\Http\Requests\Admin\Opportunities\UpdateRequest;
use App\Http\Resources\OpportunityResource;
use App\Imports\ImportOpportunities;
use App\TuChance\Models\Opportunity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OpportunitiesController extends Controller
{
    /**
     * Opportunity model
     * @var \App\TuChance\Models\Opportunity
     */
    protected $opportunities;

    /**
     * Relations to load for a given resource
     * @var array
     */
    protected $relations = [
        'image', 'bidder.user.avatar', 'category', 'state', 'city', 'country',
        'tags', 'skills',
    ];

    /**
     * Create a new controller instance
     * @param  \App\TuChance\Models\Opportunity $opportunities
     * @return void
     */
    public function __construct(Opportunity $opportunities)
    {
        $this->opportunities = $opportunities;
    }

    /**
     * Compose base query.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function query(Request $request)
    {
        $query = $this->opportunities->with($this->relations);

        if ($request->user()->hasRole('bidder')) {
            $bidder_id = $request->user()->bidder->id;
            $query->where('bidder_id', $bidder_id);
        }

        return $query;
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\ResourceCollection
     */
    public function index(Request $request)
    {
        $query = $this->query($request);

        if (!$request->user()->hasRole('bidder') && $request->has('bidder_id')) {
            $query->where('bidder_id', $request->get('bidder_id'));
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->get('category_id'));
        }

        if ($request->has('active')) {
            $query->where('is_active', $request->get('active'));
        }

        if ($request->has('available')) {
            if ($request->get('available')) {
                $query->available();
            } else {
                $query->notAvailable();
            }
        }

        if ($request->has('country_id')) {
            $query->where('opportunities.country_id', $request->get('country_id'));
        }

        if ($request->has('state_id')) {
            $query->where('opportunities.state_id', $request->get('state_id'));
        }

        if ($request->has('city_id')) {
            $query->where('opportunities.city_id', $request->get('city_id'));
        }

        if ($request->has('term')) {
            $query->search($request->get('term'), null, true, true);
        } else {
            $query->latest();
        }

        $opportunities = $query->paginate(10);

        return OpportunityResource::collection($opportunities);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \App\Http\Requests\Admin\Opportunities\CreateRequest  $request
     * @return \App\Http\Resources\OpportunityResource
     */
    public function store(CreateRequest $request)
    {
        $opportunity = $this->opportunities->newInstance();
        $opportunity->fill($request->validated());

        if ($request->user()->hasRole('bidder')) {
            $opportunity->bidder()->associate($request->user()->bidder);
        }

        if ($request->has('is_featured')) {
            $opportunity->is_featured = !!$request->get('is_featured', 0);
        }

        if (
            $request->has('is_active') &&
            $request->user()->hasRole('admin')
        ) {
            $opportunity->is_active = !!$request->get('is_active', 0);
        }

        $opportunity->save();

        $opportunity->tags()->sync($request->get('tag_ids', []));
        $opportunity->skills()->sync($request->get('skill_ids', []));

        event(new OpportunityCreated($opportunity));

        $this->cropImage($opportunity, 'image', $request);

        return new OpportunityResource($opportunity->fresh($this->relations));
    }

    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     * @return \App\Http\Resources\OpportunityResource
     */
    public function show(Request $request, $id)
    {
        $opportunity = $this->query($request)->findOrFail($id);
        return new OpportunityResource($opportunity);
    }

    /**
     * Update the specified resource in storage.
     * @param  \App\Http\Requests\Admin\Opportunities\UpdateRequest  $request
     * @param  int                                                   $id
     * @return \App\Http\Resources\OpportunityResource
     */
    public function update(UpdateRequest $request, $id)
    {
        $opportunity = $this->query($request)->findOrFail($id);
        $opportunity->fill($request->validated());

        if ($request->has('is_featured')) {
            $opportunity->is_featured = !!$request->get('is_featured', 0);
        }

        if (
            $request->has('is_active') &&
            $request->user()->hasRole('admin')
        ) {
            $opportunity->is_active = !!$request->get('is_active', 0);
        }

        $opportunity->save();

        $opportunity->tags()->sync($request->get('tag_ids', []));
        $opportunity->skills()->sync($request->get('skill_ids', []));

        $this->cropImage($opportunity, 'image', $request);

        return new OpportunityResource($opportunity->fresh($this->relations));
    }

    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     * @return \App\Http\Resources\OpportunityResource
     */
    public function destroy(Request $request, $id)
    {
        $opportunity = $this->query($request)->findOrFail($id);
        $opportunity->delete();

        return new OpportunityResource($opportunity);
    }

    /**
     * Toggle resource visibility
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \App\Http\Resources\CategoryResource
     */
    public function toggle(Request $request, $id)
    {
        $opportunity = $this->query($request)->findOrFail($id);

        $opportunity->is_active  = !$opportunity->is_active;
        $opportunity->timestamps = false;

        $opportunity->save();

        return new OpportunityResource($opportunity->fresh($this->relations));
    }

    /**
     * Import given file to database
     * @param  \App\Http\Requests\Admin\ImportRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(ImportRequest $request)
    {
        $job = new ImportOpportunities;
        $job->import($request->file('file'));

        return new JsonResponse([
            'success' => $job->wasSuccessful(),
            'message' => $job->getResult(),
        ], $job->wasSuccessful() ? 200 : 422);
    }

    /**
     * Export all resources to excel
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function download(Request $request)
    {
        $user = auth()->user();

        $query = $this->opportunities->newQuery();

        if ($begin_at = $request->get('from')) {
            $query->where('opportunities.created_at', '>=', $begin_at);
        }

        if ($finish_at = $request->get('to')) {
            $query->where('opportunities.created_at', '<=', $finish_at);
        }

        if ($user->hasRole('bidder')) {
            $query->where('bidder_id', $user->bidder->id);
        }

        $rows = $query
            ->with([
                'bidder.country', 'bidder.state', 'bidder.city', 'bidder.user',
                'country', 'state', 'city', 'category',
            ])
            ->get()
            ->toArray();

        return app('excel')->download(
            new BaseExport($rows, 'exports.enrollments'),
            'Oportunidades_' . date('Y-m-d H:i:s') . '.xlsx'
        );
    }
}
