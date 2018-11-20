<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['children'];

    /**
     * A Fractal transformer.
     *
     * @param Category $category
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'name' => $category->name,
            'slug' => $category->slug
        ];
    }

    /**
     * Return optional list of children Categories.
     *
     * @param Category $category
     * @return \League\Fractal\Resource\Collection
     */
    public function includeChildren(Category $category)
    {
        return $this->collection($category->children, new CategoryTransformer());
    }
}
