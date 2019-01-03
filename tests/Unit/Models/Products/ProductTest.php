<?php

namespace Tests\Unit\Models\Products;

use App\Cart\Money;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Stock;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    /**
     * @test
     */
    public function itUsesTheSlugForTheRouteKeyName()
    {
        $product = new Product();

        $this->assertEquals($product->getRouteKeyName(), 'slug');
    }

    /**
     * @test
     */
    public function itHasManyCategories()
    {
        $product = factory(Product::class)->create();

        $product->categories()->save(
            factory(Category::class)->create()
        );

        $this->assertInstanceOf(Category::class, $product->categories->first());
    }

    /**
     * @test
     */
    public function itHasManyVariations()
    {
        $product = factory(Product::class)->create();

        $product->variations()->save(
            factory(ProductVariation::class)->create()
        );

        $this->assertInstanceOf(ProductVariation::class, $product->variations->first());
    }

    /**
     * @test
     */
    public function itReturnsAMoneyInstanceForThePrice()
    {
        $product = factory(Product::class)->create();

        $this->assertInstanceOf(Money::class, $product->price);
    }

    /**
     * @test
     */
    public function itReturnsAFormattedPrice()
    {
        $product = factory(Product::class)->create([
            'price' => 1000
        ]);

        $this->assertEquals($product->formattedPrice, '£10.00');
    }

    /**
     * @test
     */
    public function itCanCheckIfItsInStock()
    {
        $product = factory(Product::class)->create();

        $product->variations()->save(
            $variation = factory(ProductVariation::class)->create()
        );

        $variation->stocks()->save(
            factory(Stock::class)->make()
        );

        $this->assertTrue($product->inStock());
    }

    /**
     * @test
     */
    public function itCanGetTheStockCount()
    {
        $product = factory(Product::class)->create();

        $product->variations()->save(
            $variation = factory(ProductVariation::class)->create()
        );

        $variation->stocks()->save(
            factory(Stock::class)->make([
                'quantity' => $quantity = 5
            ])
        );

        $this->assertEquals($product->stockCount(), 5);
    }
}
