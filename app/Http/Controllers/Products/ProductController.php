<?php

namespace App\Http\Controllers\Products;

use App\Models\Product;
use App\Transformers\ProductIndexTransformer;
use App\Transformers\ProductTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class ProductController extends Controller
{
    /**
     * Return an index of Products.
     * 
     * @return mixed
     */
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

    /**
     * Show selected Product.
     *
     * @param Product $product
     * @return array
     */
    public function show(Product $product)
    {
        return fractal()
            ->item($product)
            ->transformWith(new ProductTransformer())
            ->toArray();
    }
}
