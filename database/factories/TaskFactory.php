<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'title'      => $faker->sentence,
        'finished'   => false,
        'due'        => now()->addDays(rand(1, 5)),
        'project_id' => \App\Project::first()->id,
    ];
});
