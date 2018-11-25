<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductShowTest extends TestCase
{
    /**
     * @test
     */
    public function itFailsIfAProductCannotBeFound()
    {
        $this->json('GET', 'api/products/does-not-exist')
            ->assertStatus(404);
    }

    /**
     * @test
     */
    public function itShowsAProduct()
    {
        $product = factory(Product::class)->create();

        $this->json('GET', "api/products/{$product->slug}")
            ->assertJsonFragment([
                'id' => $product->id
            ]);
    }
}
