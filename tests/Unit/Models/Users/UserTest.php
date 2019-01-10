<?php

namespace Tests\Unit\Models\Users;

use App\Models\ProductVariation;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    public function testItHashesThePasswordWhenCreating()
    {
        $user = factory(User::class)->create([
            'password' => 'cats'
        ]);

        $this->assertNotEquals($user->password, 'cats');
    }

    public function testItHasManyCartProducts()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
            factory(ProductVariation::class)->create()
        );

        $this->assertInstanceOf(ProductVariation::class, $user->cart->first());
    }

    public function testItHasAQuantityForEachCartProduct()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
            factory(ProductVariation::class)->create(), [
                'quantity' => $quantity = 5
            ]
        );

        $this->assertEquals($user->cart->first()->pivot->quantity, $quantity);
    }
}
