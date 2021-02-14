<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('activityID');
            $table->unsignedInteger('userID');
            $table->boolean('isUsed')->default(false);
            $table->string('referralCode')->unique();
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
        Schema::dropIfExists('activity_tickets');
    }
}
