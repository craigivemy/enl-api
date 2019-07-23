<?php

use App\Division;
use App\Season;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeasonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('division_season')->insert([
            [
                'division_id' => 1,
                'season_id' => 1
            ],
            [
                'division_id' => 2,
                'season_id' => 1
            ],
            [
                'division_id' => 3,
                'season_id' => 1
            ],
            [
                'division_id' => 4,
                'season_id' => 1
            ],
            [
                'division_id' => 1,
                'season_id' => 2
            ],
            [
                'division_id' => 2,
                'season_id' => 2
            ],
            [
                'division_id' => 3,
                'season_id' => 2
            ],
            [
                'division_id' => 4,
                'season_id' => 2
            ],
            [
                'division_id' => 5,
                'season_id' => 1
            ],
        ]);
    }
}
