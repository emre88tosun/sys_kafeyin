<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('userType')->default("user");
            $table->string('name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('favDrink')->nullable();
            $table->string('identityNumber')->nullable();
            $table->string('gsmNumber')->nullable();
            $table->string('avatar')->default(url('img/dpp.png'));
            $table->integer('userPoint')->default(0);
            $table->integer('beansCount')->default(8);
            $table->string('city')->nullable();
            $table->decimal('lastLatitude',8,6)->nullable();
            $table->decimal('lastLongitude',8,6)->nullable();
            $table->timestamp('lastLogin')->nullable();
            $table->string('fcmToken')->nullable();
            $table->boolean('isBrandManager')->default(false);
            $table->unsignedInteger('brandID')->nullable();
            $table->boolean('locationVisibility')->default(true);
            $table->boolean('canPushNotif')->default(true);
            $table->boolean('canEmailNotif')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
