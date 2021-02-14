<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('cityID');
            $table->unsignedInteger('locationID');
            $table->unsignedInteger('brandID');
            $table->boolean('isCafe');
            $table->boolean('isActive')->default(true);
            $table->string('tag')->nullable();
            $table->string('featured')->nullable();
            $table->string('name');
            $table->text('address');
            $table->decimal('latitude',8,6);
            $table->decimal('longitude',8,6);
            $table->string('email');
            $table->string('landPhoneNumber')->nullable();
            $table->string('coverImageLink');
            $table->integer('todaysSearchCount')->default(0);
            $table->integer('leftDailyStoryCount')->default(1);
            $table->time('monOpen');
            $table->time('tueOpen');
            $table->time('wedOpen');
            $table->time('thuOpen');
            $table->time('friOpen');
            $table->time('satOpen');
            $table->time('sunOpen');
            $table->time('monClose');
            $table->time('tueClose');
            $table->time('wedClose');
            $table->time('thuClose');
            $table->time('friClose');
            $table->time('satClose');
            $table->time('sunClose');
            $table->boolean('isStudy');
            $table->boolean('isDate');
            $table->boolean('isLatteArt');
            $table->boolean('isPetFriendly');
            $table->boolean('isDessert');
            $table->boolean('isMeeting');
            $table->boolean('isAlcohol');
            $table->boolean('isOutside');
            $table->boolean('isMeal');
            $table->boolean('isBreakfast');
            $table->boolean('isChocolate');
            $table->boolean('isTakePhoto');
            $table->boolean('isSelfService');
            $table->boolean('isTea');
            $table->boolean('isLiveMusic');
            $table->boolean('canTakeTakeAwayOrder')->default(false);
            $table->boolean('canTakeLocalDeliveryOrder')->default(false);
            $table->boolean('canTakeLocalCargoOrder')->default(false);
            $table->boolean('canTakeUpstateCargoOrder')->default(false);
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
        Schema::dropIfExists('stores');
    }
}
