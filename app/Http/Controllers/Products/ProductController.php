<?php

namespace App\Http\Controllers\Products;

use App\Models\Product;
use App\Transformers\ProductIndexTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);
        $productsCollection = $products->getCollection();

        return fractal()
            ->collection($productsCollection)
            ->transformWith(new ProductIndexTransformer())
            ->paginateWith(new IlluminatePaginatorAdapter($products))
            ->toArray();
    }
}
