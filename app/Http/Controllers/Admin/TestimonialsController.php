<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Testimonials\CreateRequest;
use App\Http\Requests\Admin\Testimonials\UpdateRequest;
use App\Http\Resources\TestimonialResource;
use App\TuChance\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TestimonialsController extends Controller
{
    /**
     * Testimonial model
     * @var \App\TuChance\Models\Testimonial
     */
    protected $testimonials;

    /**
     * Relations to load for a given resource
     * @var array
     */
    protected $relations = [
        'image',
    ];

    /**
     * Create a new controller instance
     * @param  \App\TuChance\Models\Testimonial $testimonials
     * @return void
     */
    public function __construct(Testimonial $testimonials)
    {
        $this->testimonials = $testimonials;
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\ResourceCollection
     */
    public function index(Request $request)
    {
        $query = $this->testimonials->with($this->relations);

        if ($request->has('term')) {
            $query->search($request->get('term'), null, true, true);
        } else {
            $query->latest();
        }

        $testimonials = $query->paginate(12);

        return TestimonialResource::collection($testimonials);
    }

    /**
     * Sortable resources
     * @return \App\Http\Resources\ResourceCollection
     */
    public function sortable()
    {
        $testimonials = $this->testimonials
            ->with($this->relations)
            ->orderBy('weight')
            ->where('is_active', 1)
            ->get();
        return TestimonialResource::collection($testimonials);
    }

    /**
     * Sort resources to a given order
     * @param  \Illuminate\Http\Request      $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sort(Request $request)
    {
        $ids  = array_filter((array) $request->get('sort', []), 'is_numeric');
        $rows = $this->testimonials->whereIn('id', $ids)->get();

        collect($ids)
            ->each(function ($id, $j) use ($rows) {
                if ($row = $rows->find($id)) {
                    $row->weight     = $j;
                    $row->timestamps = false;
                    $row->save();
                }
            });

        return new JsonResponse(['success' => true]);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \App\Http\Requests\Admin\Testimonials\CreateRequest  $request
     * @return \App\Http\Resources\TestimonialResource
     */
    public function store(CreateRequest $request)
    {
        $testimonial = $this->testimonials->newInstance();
        $testimonial->fill($request->all());
        $testimonial->save();

        $this->cropImage($testimonial, 'image', $request);

        return new TestimonialResource($testimonial->fresh($this->relations));
    }

    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     * @return \App\Http\Resources\TestimonialResource
     */
    public function show(Request $request, $id)
    {
        $testimonial = $this->testimonials->with($this->relations)
            ->findOrFail($id);
        return new TestimonialResource($testimonial);
    }

    /**
     * Update the specified resource in storage.
     * @param  \App\Http\Requests\Admin\Testimonials\UpdateRequest  $request
     * @param  int                                             $id
     * @return \App\Http\Resources\TestimonialResource
     */
    public function update(UpdateRequest $request, $id)
    {
        $testimonial = $this->testimonials->with($this->relations)
            ->findOrFail($id);
        $testimonial->fill($request->all());
        $testimonial->save();

        $this->cropImage($testimonial, 'image', $request);

        return new TestimonialResource($testimonial->fresh($this->relations));
    }

    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     * @return \App\Http\Resources\TestimonialResource
     */
    public function destroy(Request $request, $id)
    {
        $testimonial = $this->testimonials->with($this->relations)
            ->findOrFail($id);
        $testimonial->delete();

        return new TestimonialResource($testimonial);
    }

    public function toggle(Request $request, $id)
    {
        $testimonial = $this->testimonials->findOrFail($id);

        $testimonial->is_active = !$testimonial->is_active;
        $testimonial->timestamps  = false;

        $testimonial->save();

        return new TestimonialResource($testimonial->fresh($this->relations));
    }
}
