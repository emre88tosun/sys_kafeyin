<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKafeyinStoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kafeyin_stories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('cityID');
            $table->unsignedInteger('storeID');
            $table->string('imageLink')->unique();
            $table->boolean('isActive')->default(true);
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
        Schema::dropIfExists('kafeyin_stories');
    }
}
