<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelehealthCmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telehealth_cms', function (Blueprint $table) {
            $table->id();
            $table->string('symptom_title')->nullable();
            $table->text('symptom_description')->nullable();
            $table->string('offer_image_1')->nullable();
            $table->string('offer_image_2')->nullable();
            $table->string('offer_image_3')->nullable();
            $table->text('specialization_title')->nullable();
            $table->string('how_it_works_title')->nullable();
            $table->string('how_it_works_icon_1')->nullable();
            $table->string('how_it_works_icon_2')->nullable();
            $table->string('how_it_works_icon_3')->nullable();
            $table->string('how_it_works_icon_1_title')->nullable();
            $table->string('how_it_works_icon_2_title')->nullable();
            $table->string('how_it_works_icon_3_title')->nullable();
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
        Schema::dropIfExists('telehealth_cms');
    }
}
