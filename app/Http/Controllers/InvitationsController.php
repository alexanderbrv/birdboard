<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvitationRequest;
use App\Models\Project;
use App\Models\User;

class InvitationsController extends Controller
{
    public function invite(InvitationRequest $request, Project $project)
    {
        $user = User::whereEmail(request('email'))->first();

        $project->invite($user);

        return redirect($project->path());
    }
}
