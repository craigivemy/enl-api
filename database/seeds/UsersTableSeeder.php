<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Craig',
            'last_name' => 'Ivemy',
            'email' => 'craigivemy@gmail.com',
            'password' => bcrypt('ENLdeepsky04!'),
        ]);
        DB::table('users')->insert([
            'first_name' => 'Sue',
            'last_name' => 'Ivemy',
            'email' => 'sueivemy@gmail.com',
            'password' => bcrypt('password'),
        ]);
    }
}
