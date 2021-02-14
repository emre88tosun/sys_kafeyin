<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('cityID');
            $table->unsignedInteger('storeID')->nullable();
            $table->unsignedInteger('locationID')->nullable();
            $table->boolean('isActive')->default(true);
            $table->string('title');
            $table->text('desc');
            $table->string('imageLink');
            $table->date('date');
            $table->time('time');
            $table->boolean('canTicketing')->default(false);
            $table->decimal('ticketFee',10,2)->nullable();
            $table->integer('availableTicketCount')->nullable();
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
        Schema::dropIfExists('activities');
    }
}
