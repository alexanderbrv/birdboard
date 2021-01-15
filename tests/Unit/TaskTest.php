<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_project()
    {
        $task = factory(Task::class)->create();

        $this->assertInstanceOf(Project::class, $task->project);
    }

    /** @test */
    public function it_has_a_path()
    {
        $task = factory(Task::class)->create();

        $this->assertEquals('/projects/' . $task->project->id . '/tasks/' . $task->id, $task->path());
    }

    /** @test */
    public function it_can_be_marked_as_complete()
    {
        $task = factory(Task::class)->create();

        $this->assertFalse($task->fresh()->finished);

        $task->complete();

        $this->assertTrue($task->fresh()->finished);
    }

    /** @test */
    public function it_can_be_marked_as_incomplete()
    {
        $task = factory(Task::class)->create(['finished' => true]);

        $this->assertTrue($task->fresh()->finished);

        $task->incomplete();

        $this->assertFalse($task->fresh()->finished);
    }
}
