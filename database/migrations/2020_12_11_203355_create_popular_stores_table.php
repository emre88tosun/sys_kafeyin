<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePopularStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('popular_stores', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('cityID');
            $table->unsignedInteger('storeID');
            $table->boolean('isPaid')->default(false);
            $table->integer('position');
            $table->integer('viewCount')->default(0);
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
        Schema::dropIfExists('popular_stores');
    }
}
