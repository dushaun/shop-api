<?php

namespace App\Models;

use App\Cart\Money;
use App\Models\Traits\HasPrice;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasPrice;

    /**
     * Prepare price attribute for formatting.
     *
     * @param $value
     * @return Money
     */
    public function getPriceAttribute($value)
    {
        if ($value === null) {
            return $this->product->price;
        }

        return new Money($value);
    }

    /**
     * Check if the variation price differs from the product price.
     *
     * @return bool
     */
    public function priceVaries()
    {
        return $this->price->amount() !== $this->product->price->amount();
    }

    /**
     * Return in stock check of product variation.
     *
     * @return bool
     */
    public function inStock(): bool
    {
        return $this->stockCount() > 0;
    }

    /**
     * Return dynamic stock count of product variation.
     *
     * @return int
     */
    public function stockCount(): int
    {
        return $this->stock->sum('pivot.stock');
    }

    /**
     * Get the type of product variation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function type()
    {
        return $this->hasOne(ProductVariationType::class, 'id', 'product_variation_type_id');
    }

    /**
     * Get the product the variation belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the stock blocks of the selected variation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * Get the dynamic calculated stock.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stock()
    {
        return $this->belongsToMany(ProductVariation::class, 'product_variation_stock_view')
            ->withPivot(['stock', 'in_stock']);
    }
}
