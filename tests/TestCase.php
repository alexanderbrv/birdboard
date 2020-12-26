<?php

namespace Tests;

use App\Project;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null)
    {
        $this->actingAs($user ?: factory(User::class)->create());
    }

    /**
     * @param bool $authUserIsOwner
     * @return Project
     */
    protected function createProject($authUserIsOwner = false): Project
    {
        return factory(Project::class)->create(
            $authUserIsOwner ? ['owner_id' => auth()->id()] : []
        );
    }
}
