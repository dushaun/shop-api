<?php

namespace App\Models\Traits;


use Illuminate\Database\Eloquent\Builder;

trait IsOrderable
{
    /**
     * Scope for models that are orderable.
     *
     * @param Builder $builder
     * @param string $direction
     */
    public function scopeOrdered(Builder $builder, $direction = 'asc')
    {
        $builder->orderBy('order', $direction);
    }
}