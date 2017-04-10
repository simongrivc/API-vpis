<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Uporabnikdodajtoken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uporabniki', function (Blueprint $table) {
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
        Schema::table('uporabniki', function (Blueprint $table) {
            //
        });
    }
}
