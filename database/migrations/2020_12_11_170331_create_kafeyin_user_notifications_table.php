<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKafeyinUserNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kafeyin_user_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('receiverID')->nullable();
            $table->unsignedInteger('senderID')->nullable();
            $table->unsignedInteger('commentID')->nullable();
            $table->string('type');
            $table->text('desc');
            $table->boolean('isSeen')->default(false);
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
        Schema::dropIfExists('kafeyin_user_notifications');
    }
}
