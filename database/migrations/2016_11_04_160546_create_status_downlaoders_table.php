<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusDownlaodersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_downlaoders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('script');
            $table->integer('start');
            $table->integer('pages');
            $table->integer('lastPage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_downlaoders');
    }
}
