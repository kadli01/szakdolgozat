<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToFoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('foods', function (Blueprint $table) 
        {
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('foods')) 
        {
            Schema::table('foods', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
            });
        }
    }
}
