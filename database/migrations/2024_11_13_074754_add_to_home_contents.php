<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToHomeContents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_contents', function (Blueprint $table) {
            $table->string('colab_section_1_title')->nullable();
            $table->text('colab_section_1_description')->nullable();
            $table->text('colab_section_1_link')->nullable();
            $table->string('colab_section_2_title')->nullable();
            $table->text('colab_section_2_description')->nullable();
            $table->text('colab_section_2_link')->nullable();
            $table->string('colab_section_3_title')->nullable();
            $table->text('colab_section_3_description')->nullable();
            $table->text('colab_section_3_link')->nullable();

            $table->string('about_section_title')->nullable();
            $table->text('about_section_description')->nullable();
            $table->text('about_section_link')->nullable();

            $table->string('services_section_title')->nullable();

            $table->string('testimonial_section_title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_contents', function (Blueprint $table) {
            $table->dropColumn('colab_section_1_title');
            $table->dropColumn('colab_section_1_description');
            $table->dropColumn('colab_section_1_link');
            $table->dropColumn('colab_section_2_title');
            $table->dropColumn('colab_section_2_description');
            $table->dropColumn('colab_section_2_link');
            $table->dropColumn('colab_section_3_title');
            $table->dropColumn('colab_section_3_description');
            $table->dropColumn('colab_section_3_link');
            $table->dropColumn('about_section_title');
            $table->dropColumn('about_section_description');
            $table->dropColumn('about_section_link');
            $table->dropColumn('services_section_title');
            $table->dropColumn('testimonial_section_title');

        });
    }
}
