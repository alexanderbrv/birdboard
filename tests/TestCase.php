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
     * @param array $attributes
     * @return Project
     */
    protected function createProject(bool $authUserIsOwner = false, array $attributes = []): Project
    {
        return factory(Project::class)->create(
            array_merge(
                $attributes,
                $authUserIsOwner ? ['owner_id' => auth()->id()] : []
            )
        );
    }
}
