<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreRegisteredStoreUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_registered_store_users', function (Blueprint $table) {
            $table->id();
            $table->text('referralCode');
            $table->string('name');
            $table->string('surname');
            $table->string('email');
            $table->string('gsmNumber');
            $table->boolean('isBrandManager');
            $table->boolean('isStoreManager');
            $table->unsignedInteger('brandID')->nullable();
            $table->unsignedInteger('storeID')->nullable();
            $table->unsignedInteger('applicationID')->nullable();
            $table->text('detail')->nullable();
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
        Schema::dropIfExists('pre_registered_store_users');
    }
}
