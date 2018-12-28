<?php

namespace App\Http\Controllers\Categories;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Return an index of Categories.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $categories = Category::with('children')
            ->parents()
            ->ordered()
            ->get();

        return CategoryResource::collection($categories);
    }
}
