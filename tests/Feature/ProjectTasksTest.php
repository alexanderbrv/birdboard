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
    public function guests_cannot_add_a_task()
    {
        $project = $this->createProject();

        $this->post($project->pathToAddTask(), ['body' => 'Test task'])->assertRedirect('login');
    }

    /** @test */
    public function only_the_owner_of_a_project_can_add_tasks()
    {
        $this->signIn();

        $project = $this->createProject();

        $testArr = ['body' => 'Test task'];

        $this->post($project->pathToAddTask(), $testArr)
            ->assertStatus(403);
        $this->assertDatabaseMissing('tasks', $testArr);
    }

    /** @test */
    public function only_the_owner_of_a_project_can_update_a_task()
    {
        $this->signIn();

        $project = $this->createProject();
        $task = $project->addTask('test task');

        $testArr = [
            'body'     => 'Test task',
            'finished' => true,
        ];

        $this->patch($task->path(), $testArr)->assertStatus(403);

        $this->assertDatabaseMissing('tasks', $testArr);
    }

    /** @test */
    public function a_project_can_have_a_task()
    {
        $this->signIn();

        $project = $this->createProject(true);

        $testStr = 'Test task';

        $this->post($project->pathToAddTask(), ['body' => $testStr]);

        $this->get($project->path())
            ->assertSee($testStr);
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $this->signIn();

        $project = $this->createProject(true);

        $task = $project->addTask('new task');

        $testArr = [
            'body'     => 'updated',
            'finished' => true,
        ];

        $this->patch($task->path(), $testArr);

        $this->assertDatabaseHas('tasks', $testArr);
    }

    /** @test */
    public function a_task_require_a_body()
    {
        $this->signIn();

        $project = $this->createProject(true);

        $attributes = factory(Task::class)->raw(['body' => '']);

        $this->post($project->pathToAddTask(), $attributes)->assertSessionHasErrors('body');
    }
}
