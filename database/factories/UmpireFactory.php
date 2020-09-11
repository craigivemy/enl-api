<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(\App\Umpire::class, function (Faker $faker) {
    $user_ids = DB::table('teams')->pluck('id')->toArray();
    return [
        'forename'  => $faker->firstName,
        'surname'   => $faker->lastName,
        'team_id'   => $faker->randomElement($user_ids),
        'about'     => $faker->paragraph(2),
        'email'     => $faker->email,
        'phone'     => $faker->phoneNumber
    ];
});
