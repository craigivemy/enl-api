<?php

use App\Player;
use App\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlayerSeasonTeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = Team::all()->pluck('id')->toArray();
        $players = Player::all()->pluck('id')->toArray();
        $random = range(0,4);

        $faker = Faker\Factory::create();

        // loop
        // decide whether to add to two seasons or different teams maybe?
        foreach ($players as $player) {
            $random_choice = $faker->randomElement($random);
            $team_choice_1 = $faker->randomElement($teams);
            $team_choice_2 = $faker->randomElement($teams);
            DB::table('player_season_team')->insert([
                'season_id'  => 1,
                'team_id'    => $team_choice_1,
                'player_id' => $player
            ]);
            if ($random_choice < 2) {
                DB::table('player_season_team')->insert([
                    'season_id'  => 2,
                    'team_id'    => $team_choice_1,
                    'player_id' => $player
                ]);
            } else if ($random_choice === 2) {
                DB::table('player_season_team')->insert([
                    'season_id'  => 2,
                    'team_id'    => $team_choice_2,
                    'player_id' => $player
                ]);
            }
        }
    }
}
