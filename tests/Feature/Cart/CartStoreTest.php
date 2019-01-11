<?php

namespace Tests\Feature\Cart;

use App\Models\ProductVariation;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartStoreTest extends TestCase
{
    public function testItFailsIfUnauthenticated()
    {
        $this->json('POST', 'api/cart')
            ->assertStatus(401);
    }

    public function testItRequiresProducts()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user,'POST', 'api/cart')
            ->assertJsonValidationErrors(['products']);
    }

    public function testItRequiresProductsToBeAnArray()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user,'POST', 'api/cart', [
            'products' => 1
        ])->assertJsonValidationErrors(['products']);
    }

    public function testItRequiresProductsToHaveAnID()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user,'POST', 'api/cart', [
            'products' => [
                ['quantity' => 1]
            ]
        ])->assertJsonValidationErrors(['products.0.id']);
    }

    public function testItRequiresProductsToExist()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user,'POST', 'api/cart', [
            'products' => [
                ['id' => 1, 'quantity' => 1]
            ]
        ])->assertJsonValidationErrors(['products.0.id']);
    }

    public function testItRequiresProductQuantityToBeNumeric()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user,'POST', 'api/cart', [
            'products' => [
                ['id' => 1, 'quantity' => 'one']
            ]
        ])->assertJsonValidationErrors(['products.0.quantity']);
    }

    public function testItRequiresProductQuantityToBeAtLeastOne()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user,'POST', 'api/cart', [
            'products' => [
                ['id' => 1, 'quantity' => 0]
            ]
        ])->assertJsonValidationErrors(['products.0.quantity']);
    }

    public function testItCanAddProductsToUsersCart()
    {
        $user = factory(User::class)->create();

        $product = factory(ProductVariation::class)->create();

        $this->jsonAs($user,'POST', 'api/cart', [
            'products' => [
                ['id' => $product->id, 'quantity' => 2]
            ]
        ]);

        $this->assertDatabaseHas('cart_user', [
            'product_variation_id' => $product->id,
            'user_id' => $user->id,
            'quantity' => 2
        ]);
    }
}
