<?php

namespace Tests\Unit\Models\Users;

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
}
