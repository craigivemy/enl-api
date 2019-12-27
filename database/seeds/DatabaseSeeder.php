<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // $this->call(UsersTableSeeder::class);
        $this->call([
            SettingsTableSeeder::class,
            ClubsTableSeeder::class,
            DivisionsTableSeeder::class,
            SeasonsTableSeeder::class,
            TeamsTableSeeder::class,
            PlayersTableSeeder::class,
            StatisticsTableSeeder::class,
            UmpiresTableSeeder::class,
            //DivisionSeasonTableSeeder::class,
            //SeasonTeamTableSeeder::class
            DivisionSeasonTeamTableSeeder::class,
            MatchesTableSeeder::class
        ]);

    }
}
