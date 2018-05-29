<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foods', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('name');
            $table->integer('energy');
            $table->integer('protein');
            $table->integer('fat');
            $table->integer('carbohydrate');
            $table->integer('sugar');
            $table->integer('salt');
            $table->integer('fiber');
            $table->integer('category_id')->unsigned()->default(0);
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
        Schema::dropIfExists('foods');
    }
}
