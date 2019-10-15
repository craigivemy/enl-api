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
                if ($division == 4) {
                    break;
                }
                DB::table('division_season_team')->insert([
                    [
                        'division_id' => $division,
                        'season_id' => $season,
                        'team_id' => $teams[array_rand($teams)]
                    ]
                ]);
            }
        }


    }
}
