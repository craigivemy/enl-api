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
                'name'  => 'Pool A',
                'current' => true
            ],
            [
                'name'  => 'Pool B',
                'current' => true,
            ],
            [
                'name'  => 'Pool C',
                'current' => true
            ],
            [
                'name'  => 'Pool D',
                'current' => true
            ],
            [
                'name'  => 'Mixed',
                'current' => false
            ]
        ]);
    }
}
