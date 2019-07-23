<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeasonTeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = App\Team::all()->pluck('id');

        foreach ($teams as $team) {
            if ($team % 3 == 0) {
                DB::table('season_team')->insert([
                    [
                        'season_id' => 1,
                        'team_id'   => $team
                    ],
                    [
                        'season_id' => 2,
                        'team_id'   => $team
                    ]
                ]);
            } else {
                DB::table('season_team')->insert([
                    'season_id' => 2,
                    'team_id'   => $team
                ]);
            }
        }
    }
}
