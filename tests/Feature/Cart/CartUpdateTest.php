<?php

namespace Tests\Feature\Cart;

use App\Models\ProductVariation;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartUpdateTest extends TestCase
{
    public function testItFailsIfUnauthenticated()
    {
        $this->json('PATCH', 'api/cart/1')
            ->assertStatus(401);
    }

    public function testItFailsIfProductCannotBeFound()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user,'PATCH', 'api/cart/1')
            ->assertStatus(404);
    }

    public function testItRequiresAQuantity()
    {
        $user = factory(User::class)->create();

        $product = factory(ProductVariation::class)->create();

        $this->jsonAs($user,'PATCH', "api/cart/{$product->id}")
            ->assertJsonValidationErrors(['quantity']);
    }

    public function testItRequiresANumericQuantity()
    {
        $user = factory(User::class)->create();

        $product = factory(ProductVariation::class)->create();

        $this->jsonAs($user,'PATCH', "api/cart/{$product->id}", [
            'quantity' => 'one'
        ])->assertJsonValidationErrors(['quantity']);
    }

    public function testItRequiresAQuantityOfOneOrMore()
    {
        $user = factory(User::class)->create();

        $product = factory(ProductVariation::class)->create();

        $this->jsonAs($user,'PATCH', "api/cart/{$product->id}", [
            'quantity' => 0
        ])->assertJsonValidationErrors(['quantity']);
    }

    public function testItUpdatesTheQuantityOfAProduct()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
            $product = factory(ProductVariation::class)->create(), [
                'quantity' => 1
            ]
        );

        $this->jsonAs($user,'PATCH', "api/cart/{$product->id}", [
            'quantity' => $quantity = 5
        ]);

        $this->assertDatabaseHas('cart_user', [
            'product_variation_id' => $product->id,
            'quantity' => $quantity
        ]);
    }
}
