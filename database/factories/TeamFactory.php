<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(\App\Team::class, function (Faker $faker) {

    $division_ids = DB::table('divisions')->pluck('id')->toArray();
    $club_ids = DB::table('clubs')->pluck('id')->toArray();

    return [
        'name'                  => $faker->company,
        'primary_colour'        => $faker->rgbColor,
        'secondary_colour'      => $faker->rgbColor,
        'tertiary_colour'       => $faker->rgbColor,
        'logo_url'              => $faker->imageUrl(),
        'narrative'             => $faker->paragraph(),
        'division_id'           => $division_ids[array_rand($division_ids)],
        'club_id'               => $club_ids[array_rand($club_ids)]
    ];
});
