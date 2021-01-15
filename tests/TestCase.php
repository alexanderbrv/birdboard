<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null)
    {
        $user = $user ?? $this->newUser();

        $this->actingAs($user);

        return $user;
    }

    protected function newUser()
    {
        return factory(User::class)->create();
    }
}
