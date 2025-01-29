<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('doctor_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->text('meeting_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('currency')->nullable();
            $table->longText('payment_response')->nullable();
            $table->text('start_url')->nullable();
            $table->text('join_url')->nullable();
            $table->string('call_duration')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
