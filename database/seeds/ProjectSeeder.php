<?php

use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Project::class, 5)->create()->each(function ($project) {
            factory(\App\Models\Task::class, 4)->create([
                'project_id' => $project->id,
            ]);
        });

        factory(\App\Models\Project::class, 5)->create(
            ['owner_id' => \App\Models\User::first()]
        )->each(function ($project) {
            factory(\App\Models\Task::class, 4)->create([
                'project_id' => $project->id,
            ]);
        });
    }
}
