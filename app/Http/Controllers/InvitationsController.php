<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;

class InvitationsController extends Controller
{
    public function invite(Project $project)
    {
        $this->authorize('author-or-member', $project);

        request()->validate([
            'email' => ['required', 'exists:users,email'],
        ], [
            'email.exists' => "The user you are inviting must have a " . config('app.name') . " account",
        ]);

        $user = User::whereEmail(request('email'))->first();

        $project->invite($user);

        return redirect($project->path());
    }
}
