<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnershipApplicationReferralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ownership_application_referrals', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('brandID');
            $table->text('referralCode')->unique();
            $table->boolean('isUsed')->default(false);
            $table->boolean('isValid')->default(true);
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
        Schema::dropIfExists('ownership_application_referrals');
    }
}
