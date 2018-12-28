<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductIndexTest extends TestCase
{
    /**
     * @test
     */
    public function itReturnsACollectionOfProducts()
    {
        $products = factory(Product::class, 2)->create();

        $response = $this->json('GET', 'api/products');

        $products->each(function ($product) use ($response) {
            $response->assertJsonFragment([
                'slug' => $product->slug
            ]);
        });
    }

    /**
     * @test
     */
    public function itHasPaginatedData()
    {
        $this->json('GET', 'api/products')
            ->assertJsonStructure([
                'data',
                'links',
                'meta'
            ]);
    }
}
