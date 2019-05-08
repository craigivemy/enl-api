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
                'name'  => 'points_win',
                'setting_value' => 5,
                'description'   => 'Points for a win'
            ],
            [
                'name'  => 'points_draw',
                'setting_value' => 2,
                'description'   => 'Points for a draw'
            ],
            [
                'name'  => 'points_lose',
                'setting_value' => 0,
                'description'   => 'Points for a loss'
            ],
            [
                'name'  => 'points_bonus',
                'setting_value' => 1,
                'description'   => 'Bonus points'
            ]
        ]);
    }
}
