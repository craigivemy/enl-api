<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(\App\Player::class, function (Faker $faker) {

    $team_ids = DB::table('teams')->pluck('id')->toArray();

    return [
        'forename'          => $faker->firstName,
        'surname'           => $faker->lastName
    ];
});
