<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Enrollments\UpdateRequest;
use App\Http\Resources\EnrollmentResource;
use App\Jobs\ExportExcel;
use App\TuChance\Models\Enrollment;
use App\Exports\BaseExport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class EnrollmentsController extends Controller
{
    /**
     * Enrollment model
     * @var \App\TuChance\Models\Enrollment
     */
    protected $enrollments;

    /**
     * Relations to load for a given resource
     * @var array
     */
    protected $relations = [
        'candidate.user.avatar',
        'candidate.country',
        'candidate.state',
        'candidate.city',
        'candidate.skills',
        'opportunity.bidder.user.avatar',
        'opportunity.bidder.user.avatar',
        'opportunity.country',
        'opportunity.state',
        'opportunity.city',
        'opportunity.skills',
    ];

    /**
     * Create a new controller instance
     * @param  \App\TuChance\Models\Enrollment $enrollments
     * @return void
     */
    public function __construct(Enrollment $enrollments)
    {
        $this->enrollments = $enrollments;
    }

    /**
     * Compose base query.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function query(Request $request) {
        $query = $this->enrollments->with($this->relations);

        if ($request->user('api')->hasRole('bidder')) {
            $bidder    = $request->user('api')->bidder ?? null;
            $bidder_id = $bidder->id ?? 0;

            $query->whereHas('opportunity', function ($query) use ($bidder_id) {
                $query->where('opportunities.bidder_id', $bidder_id);
            });
        }

        return $query;
    }

    /**
     * Apply filters to a given query
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  \Illuminate\Http\Request              $request
     * @return void
     */
    public function filter(Builder $query, Request $request)
    {
        if ($request->has('term')) {
            $query->search($request->get('term'), null, true, true);
        } else {
            $query->latest();
        }

        if ($request->has('opportunity_id')) {
            $query->where('opportunity_id', $request->get('opportunity_id'));
        }

        if ($request->has('candidate_id')) {
            $query->where('candidate_id', $request->get('candidate_id'));
        }

        if ($request->has('is_accepted')) {
            $query->where('is_accepted', (bool) $request->get('is_accepted'));
        }

        if ($request->has('is_fullfilled')) {
            $query->where('is_fullfilled', (bool) $request->get('is_fullfilled'));
        }
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\ResourceCollection
     */
    public function index(Request $request)
    {
        $query = $this->query($request);
        $this->filter($query, $request);
        $enrollments = $query->has('opportunity')->paginate(10);
        return EnrollmentResource::collection($enrollments);
    }

    /**
     * Update the specified resource in storage.
     * @param  \App\Http\Requests\Admin\Enrollments\UpdateRequest  $request
     * @param  int                                             $id
     * @return \App\Http\Resources\EnrollmentResource
     */
    public function update(UpdateRequest $request, $id)
    {
        $enrollment = $this->query($request)->findOrFail($id);
        $enrollment->fill($request->all());
        $enrollment->save();

        return new EnrollmentResource($enrollment->fresh($this->relations));
    }

    /**
     * Toggle resource accepted flag
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \App\Http\Resources\EnrollmentResource
     */
    public function toggleAccepted(Request $request, $id)
    {
        $enrollment = $this->query($request)->findOrFail($id);

        $enrollment->is_accepted = !$enrollment->is_accepted;
        $enrollment->timestamps  = false;

        $enrollment->save();

        return new EnrollmentResource($enrollment->fresh($this->relations));
    }

    /**
     * Toggle resource completed flag
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \App\Http\Resources\EnrollmentResource
     */
    public function toggleFullfilled(Request $request, $id)
    {
        $enrollment = $this->query($request)->findOrFail($id);

        $enrollment->is_fullfilled = !$enrollment->is_fullfilled;
        $enrollment->timestamps = false;

        $enrollment->save();

        return new EnrollmentResource($enrollment->fresh($this->relations));
    }

    /**
     * Export all resources to excel
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function download(Request $request)
    {
        $query = $this->enrollments->newQuery();
        $this->filter($query, $request);

        if ($begin_at = $request->get('from')) {
            $query->where('created_at', '>=', $begin_at);
        }

        if ($finish_at = $request->get('to')) {
            $query->where('created_at', '<=', $finish_at);
        }

        $query->with([
            'candidate.user.country', 'candidate.user.state',
            'candidate.user.city', 'opportunity.country', 'opportunity.state',
            'opportunity.city',
        ]);

        $rows = $query->get()->each(function ($row) {
            $row->is_accepted = $row->is_accepted ? 'Aceptada' : 'Pendiente';
            $row->is_fullfilled = $row->is_fullfilled ? 'Completada' : 'Pendiente';
        })->toArray();

        return app('excel')->download(
            new BaseExport($rows, 'exports.enrollments'),
            'Solicitudes_' . date('Y-m-d H:i:s') . '.xlsx'
        );
    }
}
