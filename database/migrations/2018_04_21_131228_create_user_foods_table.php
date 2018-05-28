<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_foods', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('food_id')->unsigned();
            $table->date('date');
            $table->integer('quantity');
            $table->timestamps();
        });

        Schema::table('user_foods', function (Blueprint $table) 
        {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('food_id')->references('id')->on('foods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_foods');
    }
}
