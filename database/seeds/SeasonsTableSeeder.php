<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('seasons')->insert([
            [
                'name'  => 'Winter 2019/20',
                'start_date' => '2017-10-01',
                'end_date'  => '2018-04-01',
                'rounds'    => 2,
                'current'   => true
            ],
            [
                'name'  => 'Summer 2019',
                'start_date' => '2018-06-01',
                'end_date'  => '2018-09-01',
                'rounds'    => 2,
                'current'   => false
            ]
        ]);
    }
}
