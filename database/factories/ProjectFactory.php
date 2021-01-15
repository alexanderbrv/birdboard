<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Project;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'title'       => $faker->sentence(4),
        'description' => $faker->sentence(4),
        'notes'       => $faker->paragraph,
        'owner_id'    => factory(User::class),
    ];
});
