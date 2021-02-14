<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMakinaSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('makina_searches', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('cityID');
            $table->unsignedInteger('userID');
            $table->string('tag1');
            $table->string('tag2');
            $table->string('tag3');
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
        Schema::dropIfExists('makina_searches');
    }
}
