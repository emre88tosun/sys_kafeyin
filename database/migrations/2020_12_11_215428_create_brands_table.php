<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('isEnabledLoyaltyCard')->default(true);
            $table->integer('needStampCount')->default(6);
            $table->string('logo');
            $table->boolean('isPremium')->default(false);
            $table->decimal('premiumPlanFeePerStore',6,2)->nullable();
            $table->decimal('takeAwayOrderCommissionPercent',3,1)->nullable();
            $table->decimal('otherOrdersCommissionPercent',3,1)->nullable();
            $table->decimal('activityTicketingCommissionPercent',3,1)->nullable();
            $table->text('adminNote')->nullable();
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
        Schema::dropIfExists('brands');
    }
}
