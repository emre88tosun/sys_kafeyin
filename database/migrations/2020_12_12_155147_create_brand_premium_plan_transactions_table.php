<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandPremiumPlanTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_premium_plan_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('brandID');
            $table->unsignedInteger('userID');
            $table->unsignedInteger('brandManagerExtraInfoID');
            $table->decimal('fee',10,2);
            $table->boolean('isPaid')->default(false);
            $table->string('paymentID')->nullable();
            $table->string('paymentTransactionID')->nullable();
            $table->decimal('paidPrice',10,2)->nullable();
            $table->boolean('isInvoiceSent')->nullable();
            $table->boolean('isFailed')->nullable();
            $table->text('failDesc')->nullable();
            $table->string('systemTime')->nullable();
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
        Schema::dropIfExists('brand_premium_plan_transactions');
    }
}
