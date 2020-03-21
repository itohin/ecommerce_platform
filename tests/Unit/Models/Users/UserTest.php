<?php

namespace Tests\Unit\Models\Users;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{

    public function test_it_hashes_the_password_when_creating()
    {
        $user = factory(User::class)->create(['password' => $password = 'password']);

        $this->assertNotEquals($user->password, $password);
    }
}
