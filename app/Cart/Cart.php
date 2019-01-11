<?php

namespace App\Cart;

use App\Models\User;

class Cart
{
    protected $user;

    /**
     * Cart constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Add users products to their cart.
     *
     * @param $products
     */
    public function add($products)
    {
        $this->user->cart()->syncWithoutDetaching($this->getStorePayload($products));
    }

    /**
     * Format product data for storing.
     *
     * @param $products
     * @return array
     */
    protected function getStorePayload(array $products): array
    {
        return collect($products)->keyBy('id')->map(function ($product) {
            return [
                'quantity' => $product['quantity'] + $this->getCurrentQuantity($product['id'])
            ];
        })->toArray();
    }

    /**
     * Return quantity of product in users cart, if there is any.
     *
     * @param int $productId
     * @return int
     */
    protected function getCurrentQuantity(int $productId): int
    {
        if ($product = $this->user->cart->where('id', $productId)->first()) {
            return $product->pivot->quantity;
        }

        return 0;
    }
}