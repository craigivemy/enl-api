<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('divisions')->insert([
            [
                'name'  => 'Division 1'
            ],
            [
                'name'  => 'Division 2'
            ],
            [
                'name'  => 'Division 3'
            ],
            [
                'name'  => 'Division 4'
            ],
            [
                'name'  => 'Division 5'
            ],
            [
                'name'  => 'Mixed'
            ]
        ]);
    }
}
