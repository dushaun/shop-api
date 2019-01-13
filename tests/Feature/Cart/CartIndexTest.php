<?php

namespace Tests\Feature\Cart;

use App\Models\ProductVariation;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartIndexTest extends TestCase
{
    public function testItFailsIfUnauthenticated()
    {
        $this->json('GET', 'api/cart')
            ->assertStatus(401);
    }

    public function testItShowsProductsInTheUserCart()
    {
        $user = factory(User::class)->create();

        $user->cart()->save(
            $product = factory(ProductVariation::class)->create()
        );

        $this->jsonAs($user,'GET', 'api/cart')
            ->assertJsonFragment([
                'id' => $product->id
            ]);
    }
}
