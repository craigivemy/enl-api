<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeasonTeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = App\Team::all()->pluck('id')->toArray();
        $divisions = App\Division::all()->pluck('id');
        $seasons = App\Season::all()->pluck('id');

        foreach ($seasons as $season) {
            foreach ($divisions as $division) {
                if ($division == 4 && $season == 2) {
                    break;
                }
                $team1 = $teams[array_rand($teams)];
                $team2 = $teams[array_rand($teams)];
                $team3 = $teams[array_rand($teams)];
                DB::table('division_season_team')->insert([
                    [
                        'division_id' => $division,
                        'season_id' => $season,
                        'team_id' => $team1
                    ]
                ]);
                DB::table('division_season_team')->insert([
                    [
                        'division_id' => $division,
                        'season_id' => $season,
                        'team_id' => $team2
                    ]
                ]);
                DB::table('division_season_team')->insert([
                    [
                        'division_id' => $division,
                        'season_id' => $season,
                        'team_id' => $team3
                    ]
                ]);
            }
        }


    }
}
