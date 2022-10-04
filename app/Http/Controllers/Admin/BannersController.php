<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Banners\CreateRequest;
use App\Http\Requests\Admin\Banners\UpdateRequest;
use App\Http\Resources\BannerResource;
use App\TuChance\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BannersController extends Controller
{
    /**
     * Banner model
     * @var \App\TuChance\Models\Banner
     */
    protected $banners;

    /**
     * Relations to load for a given resource
     * @var array
     */
    protected $relations = [
        'image',
    ];

    /**
     * Create a new controller instance
     * @param  \App\TuChance\Models\Banner $banners
     * @return void
     */
    public function __construct(Banner $banners)
    {
        $this->banners = $banners;
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\ResourceCollection
     */
    public function index(Request $request)
    {
        $query = $this->banners->with($this->relations);

        if ($request->has('term')) {
            $query->search($request->get('term'), null, true, true);
        } else {
            $query->orderBy('name');
        }

        $banners = $query->paginate(10);

        return BannerResource::collection($banners);
    }

    /**
     * Sortable resources
     * @return \App\Http\Resources\ResourceCollection
     */
    public function sortable()
    {
        $banners = $this->banners
            ->with($this->relations)
            ->orderBy('weight')
            ->where('is_active', 1)
            ->get();
        return BannerResource::collection($banners);
    }

    /**
     * Sort resources to a given order
     * @param  \Illuminate\Http\Request      $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sort(Request $request)
    {
        $ids  = array_filter((array) $request->get('sort', []), 'is_numeric');
        $rows = $this->banners->whereIn('id', $ids)->get();

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
     * @param  \App\Http\Requests\Admin\Banners\CreateRequest  $request
     * @return \App\Http\Resources\BannerResource
     */
    public function store(CreateRequest $request)
    {
        $banner = $this->banners->newInstance();
        $banner->fill($request->all());
        $banner->save();

        $this->cropImage($banner, 'image', $request);

        return new BannerResource($banner->fresh($this->relations));
    }

    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     * @return \App\Http\Resources\BannerResource
     */
    public function show(Request $request, $id)
    {
        $banner = $this->banners->with($this->relations)->findOrFail($id);
        return new BannerResource($banner);
    }

    /**
     * Update the specified resource in storage.
     * @param  \App\Http\Requests\Admin\Banners\UpdateRequest  $request
     * @param  int                                             $id
     * @return \App\Http\Resources\BannerResource
     */
    public function update(UpdateRequest $request, $id)
    {
        $banner = $this->banners->with($this->relations)->findOrFail($id);
        $banner->fill($request->all());
        $banner->save();

        $this->cropImage($banner, 'image', $request);

        return new BannerResource($banner->fresh($this->relations));
    }

    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     * @return \App\Http\Resources\BannerResource
     */
    public function destroy(Request $request, $id)
    {
        $banner = $this->banners->with($this->relations)->findOrFail($id);
        $banner->delete();
        return new BannerResource($banner);
    }

    /**
     * Toggle resource visibility
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \App\Http\Resources\BannerResource
     */
    public function toggle(Request $request, $id)
    {
        $banner             = $this->banners->findOrFail($id);
        $banner->is_active  = !$banner->is_active;
        $banner->timestamps = false;

        $banner->save();

        return new BannerResource($banner->fresh($this->relations));
    }
}
