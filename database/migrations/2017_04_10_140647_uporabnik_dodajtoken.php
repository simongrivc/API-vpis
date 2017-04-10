<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UporabnikDodajtoken extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Uporabnik', function (Blueprint $table) {
            $table->increments('IdUporabnik');
            $table->string('ImeUporabnik');
            $table->string('api_token', 60)->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Uporabnik');
    }
}
