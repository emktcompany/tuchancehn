<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmailTemplates\CreateRequest;
use App\Http\Requests\Admin\EmailTemplates\UpdateRequest;
use App\Http\Resources\EmailTemplateResource;
use App\TuChance\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EmailTemplatesController extends Controller
{
    /**
     * EmailTemplate model
     * @var \App\TuChance\Models\EmailTemplate
     */
    protected $email_templates;

    /**
     * Relations to load for a given resource
     * @var array
     */
    protected $relations = [
        'banner', 'footer', 'sponsor',
    ];

    /**
     * Create a new controller instance
     * @param  \App\TuChance\Models\EmailTemplate    email_templates
     * @return void
     */
    public function __construct(
        EmailTemplate $email_templates
    ) {
        $this->email_templates = $email_templates;
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\ResourceCollection
     */
    public function index(Request $request)
    {
        $email_templates = $this->email_templates
            ->with($this->relations)
            ->latest()
            ->paginate(12);

        return EmailTemplateResource::collection($email_templates);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \App\Http\Requests\Admin\EmailTemplates\CreateRequest  $request
     * @return \App\Http\Resources\EmailTemplateResource
     */
    public function store(CreateRequest $request)
    {
        $email_template = $this->email_templates->newInstance();
        $email_template->fill($request->all());
        $email_template->save();

        $this->cropImage($email_template, 'banner', $request, 'banner');
        $this->cropImage($email_template, 'sponsor', $request, 'sponsor');
        $this->cropImage($email_template, 'footer', $request, 'footer');

        return new EmailTemplateResource($email_template
            ->fresh($this->relations));
    }

    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     * @return \App\Http\Resources\EmailTemplateResource
     */
    public function show(Request $request, $id)
    {
        $email_template = $this->email_templates
            ->with($this->relations)
            ->findOrFail($id);
        return new EmailTemplateResource($email_template);
    }

    /**
     * Update the specified resource in storage.
     * @param  \App\Http\Requests\Admin\EmailTemplates\UpdateRequest  $request
     * @param  int                                             $id
     * @return \App\Http\Resources\EmailTemplateResource
     */
    public function update(UpdateRequest $request, $id)
    {
        $email_template = $this->email_templates
            ->with($this->relations)
            ->findOrFail($id);
        $email_template->fill($request->all());
        $email_template->save();

        $this->cropImage($email_template, 'banner', $request, 'banner');
        $this->cropImage($email_template, 'sponsor', $request, 'sponsor');
        $this->cropImage($email_template, 'footer', $request, 'footer');

        return new EmailTemplateResource($email_template
            ->fresh($this->relations));
    }

    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     * @return \App\Http\Resources\EmailTemplateResource
     */
    public function destroy(Request $request, $id)
    {
        $email_template = $this->email_templates
            ->with($this->relations)
            ->findOrFail($id);
        $email_template->delete();
        return new EmailTemplateResource($email_template);
    }

    /**
     * Toggle resource visibility
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \App\Http\Resources\EmailTemplateResource
     */
    public function toggle(Request $request, $id)
    {
        $email_template             = $this->email_templates->findOrFail($id);
        $email_template->is_active  = !$email_template->is_active;
        $email_template->timestamps = false;

        $email_template->save();

        return new EmailTemplateResource($email_template
            ->fresh($this->relations));
    }
}
