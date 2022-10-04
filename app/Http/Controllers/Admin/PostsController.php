<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Posts\CreateRequest;
use App\Http\Requests\Admin\Posts\UpdateRequest;
use App\Http\Resources\PostResource;
use App\TuChance\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Post model
     * @var \App\TuChance\Models\Post
     */
    protected $posts;

    /**
     * Relations to load for a given resource
     * @var array
     */
    protected $relations = [
        'image', 'user',
    ];

    /**
     * Create a new controller instance
     * @param  \App\TuChance\Models\Post $posts
     * @return void
     */
    public function __construct(Post $posts)
    {
        $this->posts = $posts;
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\ResourceCollection
     */
    public function index(Request $request)
    {
        $query = $this->posts->with($this->relations);

        if ($request->has('term')) {
            $query->search($request->get('term'), null, true, true);
        } else {
            $query->latest();
        }

        $posts = $query->paginate(10);

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \App\Http\Requests\Admin\Posts\CreateRequest  $request
     * @return \App\Http\Resources\PostResource
     */
    public function store(CreateRequest $request)
    {
        $post = $this->posts->newInstance();
        $post->fill($request->all());
        $post->user()->associate($request->user());
        $post->save();

        $this->cropImage($post, 'image', $request);

        return new PostResource($post->fresh($this->relations));
    }

    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     * @return \App\Http\Resources\PostResource
     */
    public function show(Request $request, $id)
    {
        $post = $this->posts->with($this->relations)->findOrFail($id);
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     * @param  \App\Http\Requests\Admin\Posts\UpdateRequest  $request
     * @param  int                                             $id
     * @return \App\Http\Resources\PostResource
     */
    public function update(UpdateRequest $request, $id)
    {
        $post = $this->posts->with($this->relations)->findOrFail($id);
        $post->fill($request->all());
        $post->save();

        $this->cropImage($post, 'image', $request);

        return new PostResource($post->fresh($this->relations));
    }

    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     * @return \App\Http\Resources\PostResource
     */
    public function destroy(Request $request, $id)
    {
        $post = $this->posts->with($this->relations)->findOrFail($id);
        $post->delete();

        return new PostResource($post);
    }
}
