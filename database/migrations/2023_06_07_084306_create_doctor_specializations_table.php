<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorSpecializationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_specializations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->references('id')->on('users')->onDelete('cascade')->nullable();
            $table->foreignId('specialization_id')->references('id')->on('specializations')->onDelete('cascade')->nullable();
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
        Schema::dropIfExists('doctor_specializations');
    }
}
