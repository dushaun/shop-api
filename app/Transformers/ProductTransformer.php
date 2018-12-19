<?php

namespace App\Transformers;

use App\Models\Product;
use App\Transformers\Serializers\DataSerializer;
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
                ->collection($product->variations->groupBy('type.name'))
                ->transformWith(new ProductVariationTransformer())
                ->serializeWith(new DataSerializer())
                ->toArray()
        ]);
    }
}
