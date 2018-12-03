<?php

namespace App\Transformers;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends ProductIndexTransformer
{
    /**
     * A Fractal transformer.
     *
     * @param Product $product
     * @return array
     */
    public function transform(Product $product)
    {
        return array_merge(parent::transform($product), [
            'variations' => fractal()
                ->collection($product->variations)
                ->transformWith(new ProductVariationTransformer())
                ->toArray()
        ]);
    }
}
