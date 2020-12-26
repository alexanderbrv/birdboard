<?php

namespace Tests\Feature;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_projects()
    {
        $project = $this->createProject();

        $this->get(route('projects.index'))->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->get(route('projects.create'))->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
        $this->patch($project->path(), [])->assertRedirect('login');
    }

    /** @test */
    public function an_authenticated_user_cannot_manage_the_projects_of_others()
    {
        $this->signIn();

        $project = $this->createProject();

        $this->get($project->path())->assertStatus(403);
        $this->patch($project->path(), [])->assertStatus(403);
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->signIn();

        $this->get(route('projects.create'))->assertStatus(200);

        $attributes = [
            'title'       => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes'       => 'General notes.',
        ];

        $response = $this->post(route('projects.store'), $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['notes'])
            ->assertSee($attributes['description']);
        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_can_update_a_project()
    {
        $this->signIn();

        $project = $this->createProject(true, ['notes' => 'General notes.']);

        $attributes = ['notes' => 'Updated notes.'];

        $this->patch($project->path(), $attributes)
            ->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_can_view_their_project()
    {
        $this->signIn();

        $this->withoutExceptionHandling();

        $project = $this->createProject(true);

        $this->get($project->path())
            ->assertSee($project->title);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signIn();

        $attributes = factory(Project::class)->raw(['title' => '']);

        $this->post(route('projects.store'), $attributes)->assertSessionHasErrors('title');
    }
}
