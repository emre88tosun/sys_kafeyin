<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKafeyinQrCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kafeyin_qr_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('storeID');
            $table->unsignedInteger('menuItemID');
            $table->text('batch');
            $table->text('code')->unique();
            $table->string('qrImageLink');
            $table->string('status');
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
        Schema::dropIfExists('kafeyin_qr_codes');
    }
}
