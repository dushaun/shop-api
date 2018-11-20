<?php

namespace App\Models\Traits;


use Illuminate\Database\Eloquent\Builder;

trait HasChildren
{
    /**
     * Scope for model to select parent models.
     *
     * @param Builder $builder
     */
    public function scopeParents(Builder $builder)
    {
        $builder->whereNull('parent_id');
    }
}