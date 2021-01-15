<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Arrangements\ProjectArrangement;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_user()
    {
        $user = $this->signIn();

        $project = ProjectArrangement::ownedBy($user)->create();

        $this->assertInstanceOf(User::class, $project->activity->first()->user);
        $this->assertEquals($user->id, $project->activity->first()->user->id);
    }
}
