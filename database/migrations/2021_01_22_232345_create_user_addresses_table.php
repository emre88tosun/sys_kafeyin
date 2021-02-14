<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('userID');
            $table->string('name')->nullable();
            $table->string('gsmNumber')->nullable();
            $table->unsignedInteger('cityID');
            $table->unsignedInteger('countyID');
            $table->unsignedInteger('districtID');
            $table->unsignedInteger('neighborhoodID');
            $table->text('avenueStreet');
            $table->string('buildingApartmentNo');
            $table->text('desc')->nullable();
            $table->boolean('isDeleted')->default(false);
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
        Schema::dropIfExists('user_addresses');
    }
}
