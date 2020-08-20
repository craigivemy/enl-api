<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            [
                'name' => 'win_value',
                'description' => 'Points awarded for a win',
                'setting_value' => 5,
                'season_id' => 1
            ],
            [
                'name' => 'win_value',
                'description' => 'Points awarded for a win',
                'setting_value' => 115,
                'season_id' => 2
            ],
            [
                'name' => 'draw_value',
                'description' => 'Points awarded for a draw',
                'setting_value' => 3,
                'season_id' => 1
            ],
            [
                'name' => 'loss_value',
                'description' => 'Points awarded for a loss',
                'setting_value' => 0,
                'season_id' => 1
            ],
            [
                'name' => 'bonus_point_within_5_value',
                'description' => 'Value of a bonus point',
                'setting_value' => 2,
                'season_id' => 1
            ],
            [
                'name' => 'bonus_point_over_50_percent_value',
                'description' => 'Value of a bonus point',
                'setting_value' => 1,
                'season_id' => 1
            ],
            [
                'name' => 'walkover_awarded_points',
                'description' => 'Points awarded to non-guilty team in case of a walkover',
                'setting_value' => 5,
                'season_id' => 1
            ],
            [
                'name' => 'walkover_deducted_points',
                'description' => 'Points deducted to guilty team in case of a walkover',
                'setting_value' => 5,
                'season_id' => 1
            ],
            [
                'name' => 'walkover_awarded_goals',
                'description' => 'Goals awarded to non-guilty team in case of a walkover',
                'setting_value' => 15,
                'season_id' => 1
            ]
        ]);
    }
}
