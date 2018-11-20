<?php

namespace App\Http\Controllers\Categories;

use App\Models\Category;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Return an index of Categories.
     *
     * @return array
     */
    public function index()
    {
        $categories = Category::parents()
            ->ordered()
            ->get();

        return fractal()
            ->collection($categories)
            ->parseIncludes(['children'])
            ->transformWith(new CategoryTransformer())
            ->toArray();
    }
}
