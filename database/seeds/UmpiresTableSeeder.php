<?php

use Illuminate\Database\Seeder;

class UmpiresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Umpire::class, 20)->create();
    }
}
