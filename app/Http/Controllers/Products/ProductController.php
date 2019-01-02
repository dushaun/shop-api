<?php

namespace App\Http\Controllers\Products;

use App\Http\Resources\ProductIndexResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Scoping\Scopes\CategoryScope;
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
        $products = Product::with(['variations.stock'])
            ->withScopes($this->scopes())->paginate(10);

        return ProductIndexResource::collection($products);
    }

    /**
     * Show selected Product.
     *
     * @param Product $product
     * @return ProductResource
     */
    public function show(Product $product)
    {
        $product->load(['variations.type', 'variations.stock', 'variations.product']);

        return new ProductResource($product);
    }

    /**
     * Stated scopes to be used on ProductController.
     *
     * @return array
     */
    public function scopes()
    {
        return [
            'category' => new CategoryScope()
        ];
    }
}
