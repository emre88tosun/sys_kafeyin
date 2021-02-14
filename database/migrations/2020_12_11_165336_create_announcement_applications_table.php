<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncementApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcement_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('brandID');
            $table->string('title');
            $table->text('desc');
            $table->string('imageLink');
            $table->string('status')->default('need_approval');
            $table->text('adminMessage')->nullable();
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
        Schema::dropIfExists('announcement_applications');
    }
}
