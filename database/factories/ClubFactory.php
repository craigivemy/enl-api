<?php

use Faker\Generator as Faker;

$factory->define(App\Club::class, function (Faker $faker) {
    return [
        'name'              => $faker->company,
        'primary_color'     => $faker->rgbColor,
        'secondary_color'   => $faker->rgbColor,
        'tertiary_color'    => $faker->rgbColor,
        'logo_url'          => $faker->imageUrl(),
        'narrative'         => $faker->sentences()
    ];
});
