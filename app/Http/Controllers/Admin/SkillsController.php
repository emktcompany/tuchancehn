<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Skills\CreateRequest;
use App\Http\Requests\Admin\Skills\UpdateRequest;
use App\Http\Resources\SkillResource;
use App\TuChance\Models\Skill;
use Illuminate\Http\Request;

class SkillsController extends Controller
{
    /**
     * Skill model
     * @var \App\TuChance\Models\Skill
     */
    protected $skills;

    /**
     * Create a new controller instance
     * @param  \App\TuChance\Models\Skill $skills
     * @return void
     */
    public function __construct(Skill $skills)
    {
        $this->skills = $skills;
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\ResourceCollection
     */
    public function index(Request $request)
    {
        $query = $this->skills->newQuery();

        if ($request->has('term')) {
            $query->search($request->get('term'), null, true, true);
        } else {
            $query->orderBy('name');
        }

        $skills = $query->paginate(10);

        return SkillResource::collection($skills);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \App\Http\Requests\Admin\Skills\CreateRequest  $request
     * @return \App\Http\Resources\SkillResource
     */
    public function store(CreateRequest $request)
    {
        $skill = $this->skills->newInstance();
        $skill->fill($request->all());
        $skill->save();

        return new SkillResource($skill->fresh());
    }

    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     * @return \App\Http\Resources\SkillResource
     */
    public function show(Request $request, $id)
    {
        $skill = $this->skills->findOrFail($id);
        return new SkillResource($skill);
    }

    /**
     * Update the specified resource in storage.
     * @param  \App\Http\Requests\Admin\Skills\UpdateRequest  $request
     * @param  int                                             $id
     * @return \App\Http\Resources\SkillResource
     */
    public function update(UpdateRequest $request, $id)
    {
        $skill = $this->skills->findOrFail($id);
        $skill->fill($request->all());
        $skill->save();

        return new SkillResource($skill->fresh());
    }

    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     * @return \App\Http\Resources\SkillResource
     */
    public function destroy(Request $request, $id)
    {
        $skill = $this->skills->findOrFail($id);
        $skill->delete();

        return new SkillResource($skill);
    }
}
