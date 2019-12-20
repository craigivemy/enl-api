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
                'setting_value' => 5
            ],
            [
                'name' => 'draw_value',
                'description' => 'Points awarded for a draw',
                'setting_value' => 2
            ],
            [
                'name' => 'loss_value',
                'description' => 'Points awarded for a loss',
                'setting_value' => 0
            ],
            [
                'name' => 'bonus_point_value',
                'description' => 'Value of a bonus point',
                'setting_value' => 2
            ]
        ]);
    }
}
