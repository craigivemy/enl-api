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
            UsersTableSeeder::class,
            SettingsTableSeeder::class,
            ClubsTableSeeder::class,
            DivisionsTableSeeder::class,
            SeasonsTableSeeder::class,
            TeamsTableSeeder::class,
            PlayersTableSeeder::class,
            PlayedUpsTableSeeder::class,
            PlayerSeasonTeamTableSeeder::class,
            StatisticsTableSeeder::class,
            UmpiresTableSeeder::class,
            DivisionSeasonTeamTableSeeder::class,
            MatchesTableSeeder::class,
            TeamPointAdjustmentsTableSeeder::class
        ]);

    }
}
