<?php

namespace Tests\Feature;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_authorized_user_can_create_a_project()
    {
        // Create and authenticate a user
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // Prepare a project data
        $projectAttributes = factory(Project::class)->raw();

        // Create a project
        $this->post(route('projects.store'), $projectAttributes)->assertRedirect(route('projects.index'));

        // Checks
        $this->assertDatabaseHas('projects', $projectAttributes);
        $this->assertDatabaseHas('user_project', [
            'user_id'    => $user->id,
            'project_id' => Project::where($projectAttributes)->first()->id,
        ]);
        $this->get(route('projects.index'))->assertSee($projectAttributes['title']);
    }

    /** @test */
    public function a_user_can_view_a_project()
    {
        $this->withoutExceptionHandling();
        $project = factory(Project::class)->create();

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        // Create and authenticate a user
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $attributes = factory(Project::class)->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }
}
