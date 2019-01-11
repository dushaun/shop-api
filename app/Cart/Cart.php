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
     * @param $products
     */
    public function add($products)
    {
        $this->user->cart()->syncWithoutDetaching($this->getStorePayload($products));
    }

    /**
     * @param $products
     * @return array
     */
    protected function getStorePayload($products)
    {
        return collect($products)->keyBy('id')->map(function ($product) {
            return [
                'quantity' => $product['quantity']
            ];
        })->toArray();
    }
}