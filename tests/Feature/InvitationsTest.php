<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Arrangements\ProjectArrangement;
use Tests\TestCase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function non_owners_may_not_invite_users()
    {
        $project = ProjectArrangement::create();
        $user = $this->newUser();

        $assertInvitationForbidden = function () use ($user, $project) {
            $this->actingAs($user)
                ->post($project->path() . '/invitations')
                ->assertStatus(403);
        };

        $assertInvitationForbidden();

        $project->invite($user);

        $assertInvitationForbidden();
    }

    /** @test */
    function a_project_owner_can_invite_a_user()
    {
        $project = ProjectArrangement::create();

        $userToInvite = $this->newUser();

        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations', [
                'email' => $userToInvite->email,
            ])
            ->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($userToInvite));
    }

    /** @test */
    function the_email_address_must_be_associated_with_a_existing_valid_account()
    {
        $project = ProjectArrangement::create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations', ['email' => 'notuser@example.org'])
            ->assertSessionHasErrors([
                'email' => "The user you are inviting must have a " . config('app.name') . " account"
            ], null, 'invitations');
    }

    /** @test */
    function invited_user_may_update_project_details()
    {
        $project = ProjectArrangement::create();

        $project->invite($newUser = factory(User::class)->create());

        $this->actingAs($newUser);
        $this->post($project->pathToAddTask(), $task = ['body' => 'foo task']);
        $this->patch($project->path(), $attributes = ['title' => 'new title']);

        $this->assertDatabaseHas('tasks', $task);
        $this->assertDatabaseHas('projects', $attributes);
    }
}
