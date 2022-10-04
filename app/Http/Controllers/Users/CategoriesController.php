<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\TuChance\Models\Category;

class CategoriesController extends Controller
{
    /**
     * All countries.
     * @param  \App\TuChance\Models\Category $categories
     * @return void
     */
    public function index(Category $categories)
    {
        $rows = $categories
            ->with('image', 'subcategories', 'opportunity', 'banner')
            ->where('is_active', 1)
            ->orderBy('weight')
            ->get();
        return CategoryResource::collection($rows);
    }
}
