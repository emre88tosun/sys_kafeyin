<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandPremiumPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_premium_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('brandID');
            $table->date('premiumPlanStartDate');
            $table->date('currentPremiumPlanStartDate');
            $table->date('nextRenewalDate');
            $table->integer('daysPassedAfterRenewalDate')->default(0);
            $table->boolean('isPlanActive')->default(true);
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
        Schema::dropIfExists('brand_premium_plans');
    }
}
