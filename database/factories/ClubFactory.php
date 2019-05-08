<?php

use Faker\Generator as Faker;

$factory->define(App\Club::class, function (Faker $faker) {
    return [
        'name'                  => $faker->company,
        'primary_colour'        => $faker->rgbColor,
        'secondary_colour'      => $faker->rgbColor,
        'tertiary_colour'       => $faker->rgbColor,
        'logo_url'              => $faker->imageUrl(),
        'narrative'             => $faker->paragraph()
    ];
});
