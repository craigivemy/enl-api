<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(\App\Fixture::class, function (Faker $faker) {

    $range = range(5, 50);
    $rounds = [1,2];
    $played = [0,1];
    $true_or_false = [true, false];
    $dates = ['2019-11-07 11:11:03', '2019-12-07 11:17:03'];

    $division_ids = DB::table('divisions')->pluck('id')->toArray();
    $season_ids = DB::table('seasons')->pluck('id')->toArray();
    $team_ids = DB::table('teams')->pluck('id')->toArray();

    return [
        'home_score'    => $range[array_rand($range)],
        'away_score'    => $range[array_rand($range)],
        'division_id'   => $faker->randomElement($division_ids),
        'season_id'     => $faker->randomElement($season_ids),
        'home_id'       => $faker->randomElement($team_ids),
        'away_id'       => $faker->randomElement($team_ids),
        'match_date'    => $faker->dateTimeBetween('-60 days','now','Europe/London'),
        'round'         => $rounds[array_rand($rounds)],
        'played'        => $faker->randomElement($played),
        'walkover'      => $true_or_false[array_rand($true_or_false)],
        'home_adjust'   => 0,
        'away_adjust'   => 0
    ];
});
