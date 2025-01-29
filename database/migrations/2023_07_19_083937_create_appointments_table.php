<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('doctor_id')->nullable()->constrained('users');
            $table->foreignId('clinic_id')->nullable();
            $table->string('appointment_id')->nullable();
            $table->string('appointment_date')->nullable();
            $table->string('appointment_time')->nullable();
            $table->enum('appointment_status', ['Done', 'Cancel', 'Pending'])->nullable();
            $table->string('booking_time')->nullable();
            $table->string('clinic_name')->nullable();
            $table->string('clinic_phone')->nullable();
            $table->string('clinic_address')->nullable();
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
        Schema::dropIfExists('appointments');
    }
}
