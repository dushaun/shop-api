<?php

namespace App\Transformers;

use App\Models\ProductVariation;
use League\Fractal\TransformerAbstract;

class ProductVariationTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param ProductVariation $variation
     * @return array
     */
    public function transform(ProductVariation $variation)
    {
        return [
            'id' => $variation->id,
            'name' => $variation->name
        ];
    }
}
