<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence($nbWords = 8, $variableNbWords = true),
        'description' => $faker->paragraph($nbSentences = 5, $variableNbSentences = true),
    ];
});
