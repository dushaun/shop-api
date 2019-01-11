<?php

namespace App\Http\Controllers\Cart;

use App\Cart\Cart;
use App\Http\Requests\Cart\CartStoreRequest;
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
     * Store users products to their cart.
     *
     * @param CartStoreRequest $request
     * @param Cart $cart
     */
    public function store(CartStoreRequest $request, Cart $cart)
    {
        $cart->add($request->products);
    }
}
