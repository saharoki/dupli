<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->notNullable();
            $table->date('release_date')->notNullable();
            $table->text('overview')->notNullable();
            $table->binary('image')->notNullable();
            $table->float('score', 3, 1)->notNullable();
            $table->timestamps();
        });

        Schema::create('rents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->notNullable();
            $table->bigInteger('movie_id')->notNullable();
            $table->dateTime('rent_start')->notNullable();
            $table->dateTime('rent_end')->notNullable();
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
        Schema::dropIfExists('movies');
        Schema::dropIfExists('rents');
    }
}
