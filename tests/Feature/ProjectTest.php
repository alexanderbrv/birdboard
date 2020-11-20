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
        $project = factory(Project::class)->make();
        $attributes = $project->toArray();

        // Create a project
        $this->post(route('projects.store'), $attributes)->assertRedirect(route('projects.index'));

        // Checks
        $this->assertDatabaseHas('projects', $attributes);
        $this->assertDatabaseHas('user_project', [
            'user_id'    => $user->id,
            'project_id' => Project::where($attributes)->first()->id,
        ]);
        $this->get(route('projects.index'))->assertSee($attributes['title']);
    }

    /** @test */
    public function a_guest_can_not_create_a_project()
    {
        factory(User::class)->create();

        // Prepare a project data
        $project = factory(Project::class)->make();
        $attributes = $project->toArray();

        // Create a project
        $this->post(route('projects.store'), $attributes)->assertRedirect('/login');

        // Checks
        $this->assertGuest('web');
        $this->assertDatabaseMissing('projects', $attributes);
    }

    /** @test */
    public function a_user_can_see_a_project()
    {
        // Create and authenticate a user
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // Prepare a project data
        $project = factory(Project::class)->make();
        $attributes = $project->toArray();

        // Create a project
        $this->post(route('projects.store'), $attributes);
        $projectId = Project::where($attributes)->first()->id;

        // Checks
        $this->get(route('projects.show', $projectId))->assertSee($attributes['title']);
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
