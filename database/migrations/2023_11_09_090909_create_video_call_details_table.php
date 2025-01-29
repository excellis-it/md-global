<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoCallDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_call_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->references('id')->on('users')->onDelete('cascade')->nullable();
            $table->foreignId('receiver_id')->references('id')->on('users')->onDelete('cascade')->nullable();
            $table->text('meeting_id')->nullable();
            $table->text('start_url')->nullable();
            $table->text('join_url')->nullable();
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
        Schema::dropIfExists('video_call_details');
    }
}
