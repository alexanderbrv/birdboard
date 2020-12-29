<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('update', $project);

        request()->validate(['body' => 'required']);

        $project->addTask(request('body'));

        return redirect($project->path());
    }

    public function update(Project $project, Task $task)
    {
        $this->authorize('update', $task->project);

        request()->validate([
            'body'     => 'required|string',
            'finished' => 'nullable|boolean',
        ]);

        $task->update(['body' => request('body')]);

        if (request()->has('finished')) {
            $task->complete();
        }

        return redirect($project->path());
    }
}
