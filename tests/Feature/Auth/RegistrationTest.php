<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    public function testItRequiresAName()
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['name']);
    }

    public function testItRequiresAnEmail()
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['email']);
    }

    public function testItRequiresAValidEmail()
    {
        $this->json('POST', 'api/auth/register', [
            'email' => 'invalidEmail.com'
        ])->assertJsonValidationErrors(['email']);
    }

    public function testItRequiresAUniqueEmail()
    {
        $user = factory(User::class)->create();

        $this->json('POST', 'api/auth/register', [
            'email' => $user->email
        ])->assertJsonValidationErrors(['email']);
    }

    public function testItRequiresAPassword()
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['password']);
    }

    public function testItRegistersAUser()
    {
        $this->json('POST', 'api/auth/register', [
            'name' => $name = 'John',
            'email' => $email = 'john@mighlestone.co.uk',
            'password' => 'something'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'name' => $name
        ]);
    }

    public function testItReturnsAUserOnRegistration()
    {
        $this->json('POST', 'api/auth/register', [
            'name' =>  'John',
            'email' => $email = 'john@mighlestone.co.uk',
            'password' => 'something'
        ])->assertJsonFragment([
            'email' => $email
        ]);
    }
}
