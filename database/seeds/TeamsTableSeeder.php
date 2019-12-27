<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('teams')->insert([
            [
                'name' => 'Allsorts',
            ],
            [
                'name' => 'Eagles',
            ],
            [
                'name' => 'Hastings',
            ],
            [
                'name' => 'Rapids',
            ],
            [
                'name' => 'Raptors',
            ],
            [
                'name' => 'Roselands',
            ],
            [
                'name' => 'Saracens',
            ],
            [
                'name' => 'X-treme',
            ],
            [
                'name' => 'Blue Fusion',
            ],
            [
                'name' => 'Falcons',
            ],
            [
                'name' => 'Flame',
            ],
            [
                'name' => 'Hunters',
            ],
            [
                'name' => 'Hurricanes',
            ],
            [
                'name' => 'Panthers',
            ],
            [
                'name' => 'PBS',
            ],
            [
                'name' => 'Rebels',
            ],
            [
                'name' => 'Rosettes',
            ],
            [
                'name' => 'Force',
            ],
            [
                'name' => 'Little Common',
            ],
            [
                'name' => 'Jets',
            ],
            [
                'name' => 'Parklife A',
            ],
            [
                'name' => 'Rosethornes',
            ],
            [
                'name' => 'Silhouettes',
            ],
            [
                'name' => 'Thunder',
            ],
            [
                'name' => 'Welcome',
            ],
            [
                'name' => 'Bedes',
            ],
            [
                'name' => 'Eastbourne Hawks',
            ],
            [
                'name' => 'Heathfield Hawks',
            ],
            [
                'name' => 'Rampage',
            ],
            [
                'name' => 'Roses',
            ],
            [
                'name' => 'Sapphires',
            ],
            [
                'name' => 'Zodiac',
            ],
            [
                'name' => 'Cuckoos',
            ],
            [
                'name' => '-withdrawn-',
            ],
            [
                'name' => 'Eastbourne Harriers',
            ],
            [
                'name' => 'Inferno',
            ],
            [
                'name' => 'Parklife B',
            ],
            [
                'name' => 'Rockets',
            ],
            [
                'name' => 'Sparks',
            ]
        ]);

        //factory(\App\Team::class, 40)->create();
    }
}
