<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamPointAdjustmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('team_point_adjustments')->insert([
            [
                'team_id' => 5,
                'season_id' => 1,
                'reason' => "Didn't turn up",
                'reason_date' => '2019-10-01',
                'point_adjustment' => -5
            ],
//            [
//                'team_id' => 5,
//                'season_id' => 1,
//                'reason' => "Didn't turn up AGAIN",
//                'reason_date' => '2019-10-01',
//                'point_adjustment' => -10
//            ],
            [
                'team_id' => 5,
                'season_id' => 2,
                'reason' => "Didn't turn up",
                'reason_date' => '2019-10-01',
                'point_adjustment' => -200
            ],
            [
                'team_id' => 30,
                'season_id' => 1,
                'reason' => "Fielded ineligible player",
                'reason_date' => '2019-11-01',
                'point_adjustment' => -5
            ]
        ]);
    }
}
