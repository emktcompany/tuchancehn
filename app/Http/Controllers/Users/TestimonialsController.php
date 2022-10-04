<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonialResource;
use Illuminate\Http\Request;
use App\TuChance\Models\Testimonial;

class TestimonialsController extends Controller
{
    /**
     * All countries.
     * @param  \App\TuChance\Models\Testimonial $banners
     * @param  \Illuminate\Http\Request         $request
     * @return void
     */
    public function index(Testimonial $banners, Request $request)
    {
        $rows = $banners->with('image')
            ->where('is_active', 1)
            ->latest()
            ->take(5)
            ->get();
        return TestimonialResource::collection($rows);
    }
}
