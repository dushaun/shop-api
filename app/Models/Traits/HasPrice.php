<?php

namespace App\Models\Traits;

use App\Cart\Money;

trait HasPrice
{
    /**
     * Prepare price attribute for formatting.
     *
     * @param $value
     * @return Money
     */
    public function getPriceAttribute($value)
    {
        return new Money($value);
    }

    /**
     * Get formatted price.
     *
     * @return string
     */
    public function getFormattedPriceAttribute()
    {
        return $this->price->formatted();
    }
}