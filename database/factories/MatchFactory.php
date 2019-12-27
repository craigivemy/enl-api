<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(\App\Match::class, function (Faker $faker) {

    $range = range(5, 50);
    $rounds = [1,2];
    $played = [0,1];
    $true_or_false = [true, false];

    //$division_ids = DB::table('divisions')->where('id', '<=', 3)->pluck('id')->toArray();
    $division_ids = DB::table('division_season_team')->where('season_id', '=', 2)->pluck('division_id')->toArray();
    //$season_ids = DB::table('seasons')->pluck('id')->toArray();
    $season_id = 2;
    $team_ids = DB::table('teams')->pluck('id')->toArray();
    $home_ids = array_splice($team_ids, 0, 20);
    $away_ids = array_splice($team_ids, 20, 20);

    return [
        'home_score'    => $range[array_rand($range)],
        'away_score'    => $range[array_rand($range)],
        'division_id'   => $faker->randomElement($division_ids),
        'season_id'     => $season_id,
        'home_id'       => $faker->randomElement($home_ids),
        'away_id'       => $faker->randomElement($away_ids),
        'match_date'    => $faker->dateTimeBetween('-60 days','now','Europe/London'),
        'court'         => $faker->numberBetween(1, 4),
        'round'         => $rounds[array_rand($rounds)],
        'played'        => $faker->randomElement($played),
        'walkover'      => $true_or_false[array_rand($true_or_false)],
        'home_adjust'   => 0,
        'away_adjust'   => 0
    ];
});
