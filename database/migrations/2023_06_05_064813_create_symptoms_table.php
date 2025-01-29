<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSymptomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('symptoms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specialization_id')->references('id')->on('specializations')->onDelete('cascade')->nullable();
            $table->string('symptom_name');
            $table->longText('symptom_description')->nullable();
            $table->string('symptom_slug')->unique();
            $table->string('symptom_image')->nullable();
            $table->boolean('symptom_status')->default(true);
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
        Schema::dropIfExists('symptoms');
    }
}
