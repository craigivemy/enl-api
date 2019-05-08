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
                'name'  => 'Pool A'
            ],
            [
                'name'  => 'Pool B'
            ],
            [
                'name'  => 'Pool C'
            ],
            [
                'name'  => 'Pool D'
            ],
            [
                'name'  => 'Mixed'
            ]
        ]);
    }
}
