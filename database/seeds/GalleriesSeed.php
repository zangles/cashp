<?php

use Illuminate\Database\Seeder;

class GalleriesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('galleries')->insert(array (
            'name'        => 'Tetonas',
        ));
        \DB::table('galleries')->insert(array (
            'name'        => 'Gifs',
        ));
    }
}
