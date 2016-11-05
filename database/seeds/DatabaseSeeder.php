<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(AdminUserSeed::class);
         $this->call(GalleriesSeed::class);
         $this->call(StatusDSeed::class);
    }
}
