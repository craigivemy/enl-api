<?php

use Faker\Factory;
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

        $faker = Faker\Factory::create();
        $colors = [
            'rgb(244, 67, 54)',
            'rgb(233, 30, 99)',
            'rgb(156, 39, 176)',
            'rgb(103, 58, 183)',
            'rgb(63, 81, 181)',
            'rgb(33, 150, 243)',
            'rgb(3, 169, 244)',
            'rgb(0, 188, 212)',
            'rgb(0, 150, 136)',
            'rgb(76, 175, 80)',
            'rgb(139, 195, 74)',
            'rgb(205, 220, 57)',
            'rgb(255, 235, 59)',
            'rgb(255, 193, 7)',
            'rgb(255, 152, 0)',
            'rgb(255, 87, 34)',
            'rgb(121, 85, 72)',
            'rgb(158, 158, 158)',
            'rgb(96, 125, 139)'
        ];
        $colors_secondary =  [
            'rgb(244, 67, 54)',
            'rgb(233, 30, 99)',
            'rgb(156, 39, 176)',
            'rgb(103, 58, 183)',
            'rgb(63, 81, 181)',
            'rgb(33, 150, 243)',
            'rgb(3, 169, 244)',
            'rgb(0, 188, 212)',
            'rgb(0, 150, 136)',
            'rgb(76, 175, 80)',
            'rgb(139, 195, 74)',
            'rgb(205, 220, 57)',
            'rgb(255, 235, 59)',
            'rgb(255, 193, 7)',
            'rgb(255, 152, 0)',
            'rgb(255, 87, 34)',
            'rgb(121, 85, 72)',
            'rgb(158, 158, 158)',
            'rgb(96, 125, 139)',
            'rgb(0, 0, 0)',
            'rgb(255, 255, 255)',
        ];

        DB::table('teams')->insert([
            [
                'name' => 'Allsorts',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Eagles',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Hastings',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Rapids',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Raptors',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Roselands',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Saracens',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'X-treme',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Blue Fusion',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Falcons',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Flame',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Hunters',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Hurricanes',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Panthers',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'PBS',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Rebels',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Rosettes',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Force',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Little Common',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Jets',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Parklife A',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Rosethornes',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Silhouettes',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Thunder',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Welcome',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Bedes',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Eastbourne Hawks',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Heathfield Hawks',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Rampage',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Roses',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Sapphires',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Zodiac',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Cuckoos',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => '-withdrawn-',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Eastbourne Harriers',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Inferno',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Parklife B',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Rockets',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ],
            [
                'name' => 'Sparks',
                'primary_colour' => $faker->randomElement($colors),
                'secondary_colour' => $faker->randomElement($colors_secondary),
                'tertiary_colour' => $faker->randomElement($colors_secondary)
            ]
        ]);

        //factory(\App\Team::class, 40)->create();
    }
}
