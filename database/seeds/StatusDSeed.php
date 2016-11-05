<?php

use Illuminate\Database\Seeder;

class StatusDSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('status_downlaoders')->insert(array (
            'script' => 'rusas',
            'start' => 0,
            'pages' => 30,
            'lastPage' => 0
        ));
        \DB::table('status_downlaoders')->insert(array (
            'script' => 'poringa',
            'start' => 0,
            'pages' => 10,
            'lastPage' => 0
        ));
    }
}
