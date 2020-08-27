<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MatchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $range = range(5, 50);
        $rounds = [1,2];
        $season_id = 1;
        $true_or_false = [true, false, false, false, false, false];
        $played = [0,1];

        $season_1_division_1_teams = DB::table('division_season_team')->select(['team_id'])->where('division_id', '=', 1)
            ->where('season_id', '=', 1)->pluck('team_id')->toArray();
        $season_1_division_2_teams = DB::table('division_season_team')->select(['team_id'])->where('division_id', '=', 2)
            ->where('season_id', '=', 1)->pluck('team_id')->toArray();
        $season_1_division_3_teams = DB::table('division_season_team')->select(['team_id'])->where('division_id', '=', 3)
            ->where('season_id', '=', 1)->pluck('team_id')->toArray();
        $season_1_division_4_teams = DB::table('division_season_team')->select(['team_id'])->where('division_id', '=', 4)
            ->where('season_id', '=', 1)->pluck('team_id')->toArray();
        $season_1_division_5_teams = DB::table('division_season_team')->select(['team_id'])->where('division_id', '=', 5)
            ->where('season_id', '=', 1)->pluck('team_id')->toArray();


        foreach ($season_1_division_1_teams as $team) {
            foreach ($season_1_division_1_teams as $opposition) {
                if ($team != $opposition) {
                    $walkoverHome = $true_or_false[array_rand($true_or_false)];
                    $walkoverAway = $true_or_false[array_rand($true_or_false)];

                    $home_or_away = [1,2];

                    if ($walkoverAway && $walkoverHome) {
                        if ($home_or_away[array_rand($home_or_away)] === 1) {
                            $walkoverHome = true;
                            $walkoverAway = false;
                        } else {
                            $walkoverHome = false;
                            $walkoverAway = true;
                        }
                    }

                    DB::table('matches')->insert([
                       [
                           'home_score'    => $range[array_rand($range)],
                           'away_score'    => $range[array_rand($range)],
                           'division_id'   => 1,
                           'season_id'     => $season_id,
                           'home_id'       => $team,
                           'away_id'       => $opposition,
                           'match_date'    => $faker->dateTimeBetween('-60 days','now','Europe/London'),
                           'court'         => $faker->numberBetween(1, 4),
                           'round'         => $rounds[array_rand($rounds)],
                           'played'        => $faker->randomElement($played),
                           'walkover_home'  => $walkoverHome,
                           'walkover_away'  => $walkoverAway,
                           'home_adjust'   => 0,
                           'away_adjust'   => 0
                       ]
                    ]);
                }
            }
        }

        foreach ($season_1_division_2_teams as $team) {
            foreach ($season_1_division_2_teams as $opposition) {
                if ($team != $opposition) {

                    $walkoverHome = $true_or_false[array_rand($true_or_false)];
                    $walkoverAway = $true_or_false[array_rand($true_or_false)];

                    $home_or_away = [1,2];

                    if ($walkoverAway && $walkoverHome) {
                        if ($home_or_away[array_rand($home_or_away)] === 1) {
                            $walkoverHome = true;
                            $walkoverAway = false;
                        } else {
                            $walkoverHome = false;
                            $walkoverAway = true;
                        }
                    }


                    DB::table('matches')->insert([
                        [
                            'home_score'    => $range[array_rand($range)],
                            'away_score'    => $range[array_rand($range)],
                            'division_id'   => 2,
                            'season_id'     => $season_id,
                            'home_id'       => $team,
                            'away_id'       => $opposition,
                            'match_date'    => $faker->dateTimeBetween('-60 days','now','Europe/London'),
                            'court'         => $faker->numberBetween(1, 4),
                            'round'         => $rounds[array_rand($rounds)],
                            'played'        => $faker->randomElement($played),
                            'walkover_home'  => $walkoverHome,
                            'walkover_away'  => $walkoverAway,
                            'home_adjust'   => 0,
                            'away_adjust'   => 0
                        ]
                    ]);
                }
            }
        }

        foreach ($season_1_division_3_teams as $team) {
            foreach ($season_1_division_3_teams as $opposition) {
                if ($team != $opposition) {

                    $walkoverHome = $true_or_false[array_rand($true_or_false)];
                    $walkoverAway = $true_or_false[array_rand($true_or_false)];

                    $home_or_away = [1,2];


                    if ($walkoverAway && $walkoverHome) {
                        if ($home_or_away[array_rand($home_or_away)] === 1) {
                            $walkoverHome = true;
                            $walkoverAway = false;
                        } else {
                            $walkoverHome = false;
                            $walkoverAway = true;
                        }
                    }

                    DB::table('matches')->insert([
                        [
                            'home_score'    => $range[array_rand($range)],
                            'away_score'    => $range[array_rand($range)],
                            'division_id'   => 3,
                            'season_id'     => $season_id,
                            'home_id'       => $team,
                            'away_id'       => $opposition,
                            'match_date'    => $faker->dateTimeBetween('-60 days','now','Europe/London'),
                            'court'         => $faker->numberBetween(1, 4),
                            'round'         => $rounds[array_rand($rounds)],
                            'played'        => $faker->randomElement($played),
                            'walkover_home'  => $walkoverHome,
                            'walkover_away'  => $walkoverAway,
                            'home_adjust'   => 0,
                            'away_adjust'   => 0
                        ]
                    ]);
                }
            }
        }

        foreach ($season_1_division_4_teams as $team) {
            foreach ($season_1_division_4_teams as $opposition) {
                if ($team != $opposition) {

                    $walkoverHome = $true_or_false[array_rand($true_or_false)];
                    $walkoverAway = $true_or_false[array_rand($true_or_false)];

                    $home_or_away = [1,2];

                    if ($walkoverAway && $walkoverHome) {
                        if ($home_or_away[array_rand($home_or_away)] === 1) {
                            $walkoverHome = true;
                            $walkoverAway = false;
                        } else {
                            $walkoverHome = false;
                            $walkoverAway = true;
                        }
                    }

                    DB::table('matches')->insert([
                        [
                            'home_score'    => $range[array_rand($range)],
                            'away_score'    => $range[array_rand($range)],
                            'division_id'   => 4,
                            'season_id'     => $season_id,
                            'home_id'       => $team,
                            'away_id'       => $opposition,
                            'match_date'    => $faker->dateTimeBetween('-60 days','now','Europe/London'),
                            'court'         => $faker->numberBetween(1, 4),
                            'round'         => $rounds[array_rand($rounds)],
                            'played'        => $faker->randomElement($played),
                            'walkover_home'  => $walkoverHome,
                            'walkover_away'  => $walkoverAway,
                            'home_adjust'   => 0,
                            'away_adjust'   => 0
                        ]
                    ]);
                }
            }
        }

        foreach ($season_1_division_5_teams as $team) {
            foreach ($season_1_division_5_teams as $opposition) {
                if ($team != $opposition) {

                    $walkoverHome = $true_or_false[array_rand($true_or_false)];
                    $walkoverAway = $true_or_false[array_rand($true_or_false)];

                    $home_or_away = [1,2];

                    if ($walkoverAway && $walkoverHome) {
                        if ($home_or_away[array_rand($home_or_away)] === 1) {
                            $walkoverHome = true;
                            $walkoverAway = false;
                        } else {
                            $walkoverHome = false;
                            $walkoverAway = true;
                        }
                    }

                    DB::table('matches')->insert([
                        [
                            'home_score'    => $range[array_rand($range)],
                            'away_score'    => $range[array_rand($range)],
                            'division_id'   => 5,
                            'season_id'     => $season_id,
                            'home_id'       => $team,
                            'away_id'       => $opposition,
                            'match_date'    => $faker->dateTimeBetween('-60 days','now','Europe/London'),
                            'court'         => $faker->numberBetween(1, 4),
                            'round'         => $rounds[array_rand($rounds)],
                            'played'        => $faker->randomElement($played),
                            'walkover_home'  => $walkoverHome,
                            'walkover_away'  => $walkoverAway,
                            'home_adjust'   => 0,
                            'away_adjust'   => 0
                        ]
                    ]);
                }
            }
        }

        $season_2_division_1_teams = DB::table('division_season_team')->select(['team_id'])->where('division_id', '=', 1)
            ->where('season_id', '=', 2)->pluck('team_id')->toArray();
        $season_2_division_2_teams = DB::table('division_season_team')->select(['team_id'])->where('division_id', '=', 2)
            ->where('season_id', '=', 2)->pluck('team_id')->toArray();
        $season_2_division_3_teams = DB::table('division_season_team')->select(['team_id'])->where('division_id', '=', 3)
            ->where('season_id', '=', 2)->pluck('team_id')->toArray();
        $season_2_division_4_teams = DB::table('division_season_team')->select(['team_id'])->where('division_id', '=', 4)
            ->where('season_id', '=', 2)->pluck('team_id')->toArray();
        $season_2_division_5_teams = DB::table('division_season_team')->select(['team_id'])->where('division_id', '=', 5)
            ->where('season_id', '=', 2)->pluck('team_id')->toArray();
        $season_2_division_6_teams = DB::table('division_season_team')->select(['team_id'])->where('division_id', '=', 6)
            ->where('season_id', '=', 2)->pluck('team_id')->toArray();


        foreach ($season_2_division_1_teams as $team) {
            foreach ($season_2_division_1_teams as $opposition) {
                if ($team != $opposition) {

                    $walkoverHome = $true_or_false[array_rand($true_or_false)];
                    $walkoverAway = $true_or_false[array_rand($true_or_false)];

                    $home_or_away = [1,2];

                    if ($walkoverAway && $walkoverHome) {
                        if ($home_or_away[array_rand($home_or_away)] === 1) {
                            $walkoverHome = true;
                            $walkoverAway = false;
                        } else {
                            $walkoverHome = false;
                            $walkoverAway = true;
                        }
                    }

                    DB::table('matches')->insert([
                        [
                            'home_score'    => $range[array_rand($range)],
                            'away_score'    => $range[array_rand($range)],
                            'division_id'   => 1,
                            'season_id'     => 2,
                            'home_id'       => $team,
                            'away_id'       => $opposition,
                            'match_date'    => $faker->dateTimeBetween('-60 days','now','Europe/London'),
                            'court'         => $faker->numberBetween(1, 4),
                            'round'         => $rounds[array_rand($rounds)],
                            'played'        => 1,
                            'walkover_home'  => $walkoverHome,
                            'walkover_away'  => $walkoverAway,
                            'home_adjust'   => 0,
                            'away_adjust'   => 0
                        ]
                    ]);
                }
            }
        }

        foreach ($season_2_division_2_teams as $team) {
            foreach ($season_2_division_2_teams as $opposition) {
                if ($team != $opposition) {

                    $walkoverHome = $true_or_false[array_rand($true_or_false)];
                    $walkoverAway = $true_or_false[array_rand($true_or_false)];

                    $home_or_away = [1,2];

                    if ($walkoverAway && $walkoverHome) {
                        if ($home_or_away[array_rand($home_or_away)] === 1) {
                            $walkoverHome = true;
                            $walkoverAway = false;
                        } else {
                            $walkoverHome = false;
                            $walkoverAway = true;
                        }
                    }

                    DB::table('matches')->insert([
                        [
                            'home_score'    => $range[array_rand($range)],
                            'away_score'    => $range[array_rand($range)],
                            'division_id'   => 2,
                            'season_id'     => 2,
                            'home_id'       => $team,
                            'away_id'       => $opposition,
                            'match_date'    => $faker->dateTimeBetween('-60 days','now','Europe/London'),
                            'court'         => $faker->numberBetween(1, 4),
                            'round'         => $rounds[array_rand($rounds)],
                            'played'        => 1,
                            'walkover_home'  => $walkoverHome,
                            'walkover_away'  => $walkoverAway,
                            'home_adjust'   => 0,
                            'away_adjust'   => 0
                        ]
                    ]);
                }
            }
        }

        foreach ($season_2_division_3_teams as $team) {
            foreach ($season_2_division_3_teams as $opposition) {
                if ($team != $opposition) {

                    $walkoverHome = $true_or_false[array_rand($true_or_false)];
                    $walkoverAway = $true_or_false[array_rand($true_or_false)];

                    $home_or_away = [1,2];

                    if ($walkoverAway && $walkoverHome) {
                        if ($home_or_away[array_rand($home_or_away)] === 1) {
                            $walkoverHome = true;
                            $walkoverAway = false;
                        } else {
                            $walkoverHome = false;
                            $walkoverAway = true;
                        }
                    }

                    DB::table('matches')->insert([
                        [
                            'home_score'    => $range[array_rand($range)],
                            'away_score'    => $range[array_rand($range)],
                            'division_id'   => 3,
                            'season_id'     => 2,
                            'home_id'       => $team,
                            'away_id'       => $opposition,
                            'match_date'    => $faker->dateTimeBetween('-60 days','now','Europe/London'),
                            'court'         => $faker->numberBetween(1, 4),
                            'round'         => $rounds[array_rand($rounds)],
                            'played'        => 1,
                            'walkover_home'  => $walkoverHome,
                            'walkover_away'  => $walkoverAway,
                            'home_adjust'   => 0,
                            'away_adjust'   => 0
                        ]
                    ]);
                }
            }
        }

        foreach ($season_2_division_4_teams as $team) {
            foreach ($season_2_division_4_teams as $opposition) {
                if ($team != $opposition) {

                    $walkoverHome = $true_or_false[array_rand($true_or_false)];
                    $walkoverAway = $true_or_false[array_rand($true_or_false)];

                    $home_or_away = [1,2];

                    if ($walkoverAway && $walkoverHome) {
                        if ($home_or_away[array_rand($home_or_away)] === 1) {
                            $walkoverHome = true;
                            $walkoverAway = false;
                        } else {
                            $walkoverHome = false;
                            $walkoverAway = true;
                        }
                    }

                    DB::table('matches')->insert([
                        [
                            'home_score'    => $range[array_rand($range)],
                            'away_score'    => $range[array_rand($range)],
                            'division_id'   => 4,
                            'season_id'     => 2,
                            'home_id'       => $team,
                            'away_id'       => $opposition,
                            'match_date'    => $faker->dateTimeBetween('-60 days','now','Europe/London'),
                            'court'         => $faker->numberBetween(1, 4),
                            'round'         => $rounds[array_rand($rounds)],
                            'played'        => 1,
                            'walkover_home'  => $walkoverHome,
                            'walkover_away'  => $walkoverAway,
                            'home_adjust'   => 0,
                            'away_adjust'   => 0
                        ]
                    ]);
                }
            }
        }

        foreach ($season_2_division_5_teams as $team) {
            foreach ($season_2_division_5_teams as $opposition) {
                if ($team != $opposition) {

                    $walkoverHome = $true_or_false[array_rand($true_or_false)];
                    $walkoverAway = $true_or_false[array_rand($true_or_false)];

                    $home_or_away = [1,2];

                    if ($walkoverAway && $walkoverHome) {
                        if ($home_or_away[array_rand($home_or_away)] === 1) {
                            $walkoverHome = true;
                            $walkoverAway = false;
                        } else {
                            $walkoverHome = false;
                            $walkoverAway = true;
                        }
                    }

                    DB::table('matches')->insert([
                        [
                            'home_score'    => $range[array_rand($range)],
                            'away_score'    => $range[array_rand($range)],
                            'division_id'   => 5,
                            'season_id'     => 2,
                            'home_id'       => $team,
                            'away_id'       => $opposition,
                            'match_date'    => $faker->dateTimeBetween('-60 days','now','Europe/London'),
                            'court'         => $faker->numberBetween(1, 4),
                            'round'         => $rounds[array_rand($rounds)],
                            'played'        => 1,
                            'walkover_home'  => $walkoverHome,
                            'walkover_away'  => $walkoverAway,
                            'home_adjust'   => 0,
                            'away_adjust'   => 0
                        ]
                    ]);
                }
            }
        }

        foreach ($season_2_division_6_teams as $team) {
            foreach ($season_2_division_6_teams as $opposition) {
                if ($team != $opposition) {

                    $walkoverHome = $true_or_false[array_rand($true_or_false)];
                    $walkoverAway = $true_or_false[array_rand($true_or_false)];

                    $home_or_away = [1,2];

                    if ($walkoverAway && $walkoverHome) {
                        if ($home_or_away[array_rand($home_or_away)] === 1) {
                            $walkoverHome = true;
                            $walkoverAway = false;
                        } else {
                            $walkoverHome = false;
                            $walkoverAway = true;
                        }
                    }

                    DB::table('matches')->insert([
                        [
                            'home_score'    => $range[array_rand($range)],
                            'away_score'    => $range[array_rand($range)],
                            'division_id'   => 6,
                            'season_id'     => 2,
                            'home_id'       => $team,
                            'away_id'       => $opposition,
                            'match_date'    => $faker->dateTimeBetween('-60 days','now','Europe/London'),
                            'court'         => $faker->numberBetween(1, 4),
                            'round'         => $rounds[array_rand($rounds)],
                            'played'        => 1,
                            'walkover_home'  => $walkoverHome,
                            'walkover_away'  => $walkoverAway,
                            'home_adjust'   => 0,
                            'away_adjust'   => 0
                        ]
                    ]);
                }
            }
        }


        //factory(App\Match::class, 100)->create();
    }
}
