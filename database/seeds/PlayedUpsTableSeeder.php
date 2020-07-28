<?php

use App\Player;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlayedUpsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $players = Player::all()->pluck('id')->toArray();
        $range = range(1,50);
        shuffle($range);
        $random_elements = [];
        foreach ($range as $item) {
            $random_elements[] = $item;
        }

        foreach($players as $player) {
            DB::table('played_ups')->insert([
                'played_up_date' => $faker->dateTimeBetween('-60 days','now','Europe/London'),
                'player_id' => $faker->randomElement($players),
                'season_id' => $faker->randomElement([1,2])
            ]);
        }

        foreach ($random_elements as $element) {
            DB::table('played_ups')->insert([
                'played_up_date' => $faker->dateTimeBetween('-60 days','now','Europe/London'),
                'player_id' => $element,
                'season_id' => $faker->randomElement([1,2])
            ]);
        }
    }
}
