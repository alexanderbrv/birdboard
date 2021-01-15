<?php

namespace Tests\Arrangements;

use App\Project;
use App\Task;
use App\User;

class ProjectArrangement
{
    protected $tasks = 0;

    protected $user;

    public function ownedBy(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    public function ownedByNewUser()
    {
        $this->user = null;

        return $this;
    }

    /**
     * @param int $count
     * @return ProjectArrangement
     */
    public function withTasks($count = 1): self
    {
        $this->tasks = $count;

        return $this;
    }

    /**
     * @param array|null $attributes
     * @return Project
     */
    public function create(array $attributes = []): Project
    {
        $attributes += ['owner_id' => $this->user ?? factory(User::class)];

        $project = factory(Project::class)->create($attributes);

        factory(Task::class, $this->tasks)->create([
            'project_id' => $project->id
        ]);

        return $project;
    }
}