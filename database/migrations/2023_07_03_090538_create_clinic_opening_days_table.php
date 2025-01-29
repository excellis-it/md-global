<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicOpeningDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_opening_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinic_details_id')->references('id')->on('clinic_details')->onDelete('cascade')->nullable();
            $table->foreignId('day_id')->references('id')->on('days')->onDelete('cascade')->nullable();
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
        Schema::dropIfExists('clinic_opening_days');
    }
}
