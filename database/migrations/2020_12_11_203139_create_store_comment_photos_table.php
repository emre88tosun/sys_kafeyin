<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreCommentPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_comment_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('userID');
            $table->unsignedInteger('storeID');
            $table->unsignedInteger('commentID');
            $table->string('imageLink')->unique();
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
        Schema::dropIfExists('store_comment_photos');
    }
}
