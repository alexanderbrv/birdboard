<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Arrangements\ProjectArrangement;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_projects()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    /** @test */
    public function a_user_has_accessible_projects()
    {
        $john = $this->newUser();
        $nick = $this->newUser();
        $sally = $this->newUser();

        ProjectArrangement::ownedBy($john)->create();

        $this->assertCount(1, $john->accessibleProjects());

        $sallyProject = ProjectArrangement::ownedBy($sally)->create();

        $sallyProject->invite($nick);

        $this->assertCount(1, $john->accessibleProjects());

        $sallyProject->invite($john);

        $this->assertCount(2, $john->accessibleProjects());
    }
}
