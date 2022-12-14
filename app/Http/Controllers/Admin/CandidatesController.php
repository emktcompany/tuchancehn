<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BaseExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Candidates\CreateRequest;
use App\Http\Requests\Admin\Candidates\UpdateRequest;
use App\Http\Requests\Admin\ImportRequest;
use App\Http\Resources\CandidateResource;
use App\Imports\ImportCandidates;
use App\TuChance\Contracts\Repositories\Candidates;
use App\TuChance\Models\Candidate;
use App\TuChance\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CandidatesController extends Controller
{
    /**
     * Candidate model
     * @var \App\TuChance\Models\Candidate
     */
    protected $candidates;

    /**
     * User model
     * @var \App\TuChance\Models\User
     */
    protected $users;

    /**
     * Relations to load for a given resource
     * @var array
     */
    protected $relations = [
        'user.avatar', 'country', 'state', 'city', 'user.tags', 'cv',
    ];

    /**
     * Create a new controller instance
     * @param  \App\TuChance\Models\Candidate $candidates
     * @param  \App\TuChance\Models\User      $users
     * @return void
     */
    public function __construct(Candidate $candidates, User $users)
    {
        $this->candidates = $candidates;
        $this->users      = $users;
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request                         $request
     * @param  \App\TuChance\Contracts\Repositories\Candidates  $candidates
     * @return \App\Http\Resources\ResourceCollection
     */
    public function index(Request $request, Candidates $candidates)
    {
        return $candidates->search($request);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \App\Http\Requests\Admin\Candidates\CreateRequest  $request
     * @return \App\Http\Resources\CandidateResource
     */
    public function store(CreateRequest $request)
    {
        $db = $this->users->getConnection();
        $db->beginTransaction();

        try {
            $user = $this->users->newInstance();
            $user->fill($data = $request->get('user', []));
            $user->password = bcrypt($request->get('password'));
            $user->save();
            $user->syncRoles(['candidate']);

            $candidate = $this->candidates->newInstance();

            $candidate->fill(array_merge(
                $request->except('user'),
                array_only($user->getAttributes(), [
                    'country_id', 'state_id', 'city_id',
                ])
            ));

            $candidate->user()->associate($user);

            $candidate->save();

            $this->cropImage($user, 'avatar', $request);
            $this->attachFile($candidate, 'cv', $request);
        } catch (\Exception $e) {
            $db->rollback();

            return new JsonResponse([
                'error' => $e->getMessage(),
                'type'  => get_class($e),
            ], 422);
        }

        $db->commit();

        return new CandidateResource($candidate->fresh($this->relations));
    }

    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     * @return \App\Http\Resources\CandidateResource
     */
    public function show(Request $request, $id)
    {
        $candidate = $this->candidates->with($this->relations)->findOrFail($id);
        return new CandidateResource($candidate);
    }

    /**
     * Update the specified resource in storage.
     * @param  \App\Http\Requests\Admin\Candidates\UpdateRequest  $request
     * @param  int                                             $id
     * @return \App\Http\Resources\CandidateResource
     */
    public function update(UpdateRequest $request, $id)
    {
        $db = $this->users->getConnection();
        $db->beginTransaction();

        try {
            $candidate = $this->candidates->with($this->relations)
                ->findOrFail($id);
            $user = $candidate->user;
            $user->fill($data = $request->get('user', []));

            if ($request->has('password')) {
                $user->password = bcrypt($request->get('password'));
            }

            $user->save();

            $candidate->fill(array_merge(
                $request->except('user'),
                array_only($user->getAttributes(), [
                    'country_id', 'state_id', 'city_id',
                ])
            ));

            $candidate->save();

            $this->cropImage($user, 'avatar', $request);
            $this->attachFile($candidate, 'cv', $request);
        } catch (\Exception $e) {
            $db->rollback();

            return new JsonResponse([
                'error' => $e->getMessage(),
                'type'  => get_class($e),
            ], 422);
        }

        $db->commit();

        $this->cropImage($user, 'avatar', $request);

        return new CandidateResource($candidate->fresh($this->relations));
    }

    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     * @return \App\Http\Resources\CandidateResource
     */
    public function destroy(Request $request, $id)
    {
        $candidate = $this->candidates->with($this->relations)->findOrFail($id);
        $user      = $candidate->user;

        $candidate->delete();
        $user->delete();

        return new CandidateResource($candidate);
    }

    /**
     * Toggle resource visibility
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \App\Http\Resources\BannerResource
     */
    public function toggle(Request $request, $id)
    {
        $candidate = $this->candidates->findOrFail($id);
        $user      = $candidate->user;

        $user->is_active  = !$user->is_active;
        $user->timestamps = false;

        $user->save();

        return new CandidateResource($candidate->fresh($this->relations));
    }

    /**
     * Import given file to database
     * @param  \App\Http\Requests\Admin\ImportRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(ImportRequest $request)
    {
        $job = new ImportCandidates;
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
        $user  = $request->user();
        $query = $this->candidates->newQuery();

        if ($begin_at = $request->get('from')) {
            $query->where('candidates.created_at', '>=', $begin_at);
        }

        if ($finish_at = $request->get('to')) {
            $query->where('candidates.created_at', '<=', $finish_at);
        }

        $rows = $query->get()
            ->load('user.country', 'user.state', 'user.city')
            ->each(function ($user) {
                $user->gender         = $user->gender ? 'Masculino' : 'Femenino';
                $user->driver_license = $user->driver_license ? 'S??' : 'No';
            })
            ->toArray();

        return app('excel')->download(
            new BaseExport($rows, 'exports.candidates'),
            'Candidatos_' . date('Y-m-d H:i:s') . '.xlsx'
        );
    }
}
