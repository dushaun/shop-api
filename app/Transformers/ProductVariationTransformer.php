<?php

namespace App\Transformers;

use App\Models\ProductVariation;
use App\Transformers\Serializers\DataSerializer;
use Illuminate\Support\Collection;
use League\Fractal\TransformerAbstract;

class ProductVariationTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param $variation
     * @return array
     */
    public function transform($variation)
    {
        if ($variation instanceof Collection) {
            return [
                $variation->first()->type->name => fractal()
                    ->collection($variation)
                    ->transformWith(new ProductVariationTransformer())
                    ->serializeWith(new DataSerializer())
                    ->toArray()
            ];
        }

        return [
            'id' => $variation->id,
            'name' => $variation->name
        ];
    }
}
