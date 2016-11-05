<?php

use Illuminate\Database\Seeder;

class AdminUserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert(array (
            'name'        => 'azure',
            'email'       => 'azuresky07@gmail.com',
            'password'    => \Hash::make('septiembre08'),
        ));
    }
}
