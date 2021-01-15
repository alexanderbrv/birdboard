<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;

class TasksController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('author-or-member', $project);

        request()->validate(['body' => 'required']);

        $project->addTask(request('body'));

        return redirect($project->path());
    }

    public function update(Project $project, Task $task)
    {
        $this->authorize('author-or-member', $task->project);

        $attributes = request()->validate([
            'body' => 'required|string'
        ]);

        $task->update($attributes);

        request('finished') ? $task->complete() : $task->incomplete();

        return redirect($project->path());
    }
}
