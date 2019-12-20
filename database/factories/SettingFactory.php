<?php

use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
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
    ];
});
