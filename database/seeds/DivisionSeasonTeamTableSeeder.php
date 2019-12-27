<?php

use App\Division;
use App\Team;
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

        $season_ids = [1,2];
        $season_1_division_ids = Division::where('id', '<', 6)->pluck('id')->toArray();
        $season_2_division_ids = Division::where('id', '<=', 6)->pluck('id')->toArray();
        $teams_ids = Team::all()->pluck('id')->toArray();

        $i = 1;
        foreach ($teams_ids as $team_id) {
            if ($i === 5) {
                $i = 0;
            }
            DB::table('division_season_team')->insert([
                [
                    'season_id' => $season_ids[0],
                    'division_id' => $season_1_division_ids[$i],
                    'team_id' => $team_id
                ],
            ]);
            $i++;
        }

        $season_2_team_ids = array_reverse($teams_ids);
        foreach ($season_2_team_ids as $team_id) {
            if ($i === 6) {
                $i = 0;
            }
            DB::table('division_season_team')->insert([
                [
                    'season_id' => $season_ids[1],
                    'division_id' => $season_2_division_ids[$i],
                    'team_id' => $team_id
                ],
            ]);
            $i++;
        }




//        $teams = App\Team::all()->pluck('id')->toArray();
//        $divisions = App\Division::all()->pluck('id');
//        $seasons = App\Season::all()->pluck('id');
//
//        $team1 = array_splice($teams, 0, 15);
//        $team2 = array_splice($teams, 15, 15);
//        $team3 = array_splice($teams, 30, 10);
//
//        foreach ($seasons as $season) {
//            foreach ($divisions as $division) {
//                if ($division == 4 && $season == 2) {
//                    break;
//                }
//                DB::table('division_season_team')->insert([
//                    [
//                        'division_id' => $division,
//                        'season_id' => $season,
//                        'team_id' => $team1
//                    ]
//                ]);
//                DB::table('division_season_team')->insert([
//                    [
//                        'division_id' => $division,
//                        'season_id' => $season,
//                        'team_id' => $team2
//                    ]
//                ]);
//                DB::table('division_season_team')->insert([
//                    [
//                        'division_id' => $division,
//                        'season_id' => $season,
//                        'team_id' => $team3
//                    ]
//                ]);
//            }
//        }


    }
}
