<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(\App\Player::class, function (Faker $faker) {

    $team_ids = DB::table('teams')->pluck('id')->toArray();
    $played_up = range(0,3);

    return [
        'forename'          => $faker->firstName,
        'surname'           => $faker->lastName,
        'team_id'           => $faker->randomElement($team_ids),
        'played_up_count'   => $faker->randomElement($played_up)
    ];
});
