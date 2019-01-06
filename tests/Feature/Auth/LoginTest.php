<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    public function testItRequiresAnEmail()
    {
        $this->json('POST', 'api/auth/login')
            ->assertJsonValidationErrors(['email']);
    }

    public function testItRequiresAPassword()
    {
        $this->json('POST', 'api/auth/login')
            ->assertJsonValidationErrors(['password']);
    }

    public function testItReturnsErrorIfCredentialsAreIncorrect()
    {
        $user = factory(User::class)->create();

        $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => 'wrongPassword'
        ])->assertJsonValidationErrors(['email']);
    }

    public function testItReturnsATokenIfCredentialsAreCorrect()
    {
        $user = factory(User::class)->create([
            'password' => 'correct'
        ]);

        $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => 'correct'
        ])->assertJsonStructure([
            'meta' => [
                'token'
            ]
        ]);
    }

    public function testItReturnsAUserIfCredentialsAreCorrect()
    {
        $user = factory(User::class)->create([
            'password' => 'correct'
        ]);

        $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => 'correct'
        ])->assertJsonStructure([
            'data' => [
                'id',
                'email',
                'name'
            ]
        ])->assertJsonFragment([
            'email' => $user->email,
            'name' => $user->name
        ]);
    }
}
