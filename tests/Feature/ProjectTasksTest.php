<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_have_a_task()
    {
        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $testStr = 'Test task';

        $this->post($project->pathToAddTask(), ['body' => $testStr]);

        $this->get($project->path())
            ->assertSee($testStr);
    }

    /** @test */
    public function a_task_require_a_body()
    {
        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $attributes = factory(Task::class)->raw(['body' => '']);

        $this->post($project->pathToAddTask(), $attributes)->assertSessionHasErrors('body');
    }
}
