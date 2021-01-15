<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Arrangements\ProjectArrangement;
use Tests\TestCase;

class AnvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_project_can_invite_a_user()
    {
        $project = ProjectArrangement::create();

        $project->invite($newUser = factory(User::class)->create());

        $this->actingAs($newUser);
        $this->post($project->pathToAddTask(), $task = ['body' => 'foo task']);

        $this->assertDatabaseHas('tasks', $task);
    }
}
