<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MeTest extends TestCase
{
    public function testItFailsIfUserIsNotAuthenticated()
    {
        $this->json('GET', 'api/auth/me')
            ->assertStatus(401);
    }

    public function testItReturnsUserDetails()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'GET', 'api/auth/me')
            ->assertJsonFragment([
                'email' => $user->email
            ]);
    }
}
