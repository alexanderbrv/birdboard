<?php

namespace Tests\Feature;

use App\Task;
use Facades\Tests\Arrangements\ProjectArrangement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_add_a_task()
    {
        $project = ProjectArrangement::create();

        $this->post($project->pathToAddTask(), ['body' => 'Test task'])->assertRedirect('login');
    }

    /** @test */
    public function only_the_owner_of_a_project_can_add_tasks()
    {
        $this->signIn();

        $project = ProjectArrangement::create();

        $testArr = ['body' => 'Test task'];

        $this->post($project->pathToAddTask(), $testArr)
            ->assertStatus(403);
        $this->assertDatabaseMissing('tasks', $testArr);
    }

    /** @test */
    public function only_the_owner_of_a_project_can_update_a_task()
    {
        $project = ProjectArrangement::withTasks()->create();

        $testArr = [
            'body'     => 'Test task',
            'finished' => true,
        ];

        $this->signIn()
            ->patch($project->tasks[0]->path(), $testArr)
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', $testArr);
    }

    /** @test */
    public function a_project_can_have_a_task()
    {
        $project = ProjectArrangement::create();

        $this->actingAs($project->owner)
            ->post($project->pathToAddTask(), ['body' => 'Test task']);

        $this->get($project->path())
            ->assertSee('Test task');
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $project = ProjectArrangement::withTasks()->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), $testArr = ['body' => 'updated']);

        $this->assertDatabaseHas('tasks', $testArr);
    }

    /** @test */
    public function a_task_can_be_marked_as_completed()
    {
        $project = ProjectArrangement::withTasks()->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), $testArr = [
                    'body'     => 'foobar',
                    'finished' => true,
            ]);

        $this->assertDatabaseHas('tasks', $testArr);
    }

    /** @test */
    public function a_task_can_be_marked_as_incomplete()
    {
        $project = ProjectArrangement::withTasks()->create();

        $this->actingAs($project->owner);
        $this->patch($project->tasks[0]->path(), [
            'body'     => 'foobar',
            //'finished' => true,
        ]);

        $this->patch($project->tasks[0]->path(), $testArr = [
            'body'     => 'foobar',
        ]);

        $this->assertDatabaseHas('tasks', $testArr);
    }

    /** @test */
    public function a_task_require_a_body()
    {
        $project = ProjectArrangement::create();

        $attributes = factory(Task::class)->raw(['body' => '']);

        $this->actingAs($project->owner)
            ->post($project->pathToAddTask(), $attributes)
            ->assertSessionHasErrors('body');
    }
}
