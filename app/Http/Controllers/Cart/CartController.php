<?php

namespace App\Http\Controllers\Cart;

use App\Cart\Cart;
use App\Http\Requests\Cart\CartStoreRequest;
use App\Http\Requests\Cart\CartUpdateRequest;
use App\Http\Resources\Cart\CartResource;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    /**
     * CartController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    /**
     * @param Request $request
     * @return CartResource
     */
    public function index(Request $request)
    {
        $request->user()->load([
            'cart.product', 'cart.product.variations.stock', 'cart.stock'
        ]);

        return new CartResource($request->user());
    }

    /**
     * Store user's products to their cart.
     *
     * @param CartStoreRequest $request
     * @param Cart $cart
     */
    public function store(CartStoreRequest $request, Cart $cart)
    {
        $cart->add($request->products);
    }

    /**
     * Update user's products in their cart.
     *
     * @param ProductVariation $productVariation
     * @param CartUpdateRequest $request
     * @param Cart $cart
     */
    public function update(ProductVariation $productVariation, CartUpdateRequest $request, Cart $cart)
    {
        $cart->update($productVariation->id, $request->quantity);
    }

    /**
     * Remove selected product from user's cart.
     *
     * @param ProductVariation $productVariation
     * @param Cart $cart
     */
    public function destroy(ProductVariation $productVariation, Cart $cart)
    {
        $cart->delete($productVariation->id);
    }
}
