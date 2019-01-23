<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(3),
		'body' => $faker->paragraph(6),
		'tags' => join(',', $faker->words(4))
    ];
});
