<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Faqs\CreateRequest;
use App\Http\Requests\Admin\Faqs\UpdateRequest;
use App\Http\Resources\FaqResource;
use App\TuChance\Models\Faq;
use Illuminate\Http\Request;

class FaqsController extends Controller
{
    /**
     * Faq model
     * @var \App\TuChance\Models\Faq
     */
    protected $faqs;

    /**
     * Create a new controller instance
     * @param  \App\TuChance\Models\Faq $faqs
     * @return void
     */
    public function __construct(Faq $faqs)
    {
        $this->faqs = $faqs;
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\ResourceCollection
     */
    public function index(Request $request)
    {
        $query = $this->faqs->newQuery();

        if ($request->has('term')) {
            $query->search($request->get('term'), null, true, true);
        } else {
            $query->latest();
        }

        $faqs = $query->paginate(10);

        return FaqResource::collection($faqs);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \App\Http\Requests\Admin\Faqs\CreateRequest  $request
     * @return \App\Http\Resources\FaqResource
     */
    public function store(CreateRequest $request)
    {
        $faq = $this->faqs->newInstance();
        $faq->fill($request->all());
        $faq->save();

        return new FaqResource($faq->fresh());
    }

    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     * @return \App\Http\Resources\FaqResource
     */
    public function show(Request $request, $id)
    {
        $faq = $this->faqs->findOrFail($id);
        return new FaqResource($faq);
    }

    /**
     * Update the specified resource in storage.
     * @param  \App\Http\Requests\Admin\Faqs\UpdateRequest  $request
     * @param  int                                             $id
     * @return \App\Http\Resources\FaqResource
     */
    public function update(UpdateRequest $request, $id)
    {
        $faq = $this->faqs->findOrFail($id);
        $faq->fill($request->all());
        $faq->save();

        return new FaqResource($faq->fresh());
    }

    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     * @return \App\Http\Resources\FaqResource
     */
    public function destroy(Request $request, $id)
    {
        $faq = $this->faqs->findOrFail($id);
        $faq->delete();

        return new FaqResource($faq);
    }
}
