<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Model::class, function (Faker $faker) {
    $user_ids = DB::table('teams')->select('id')->get();
    return [
        'forename'  => $faker->firstName,
        'surname'   => $faker->lastName,
        'team_id'   => $faker->randomElement($user_ids)
    ];
});
