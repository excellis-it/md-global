<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToVideoCallPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_call_prices', function (Blueprint $table) {
            $table->text('title')->nullable()->after('id');
            $table->string('duration')->nullable()->after('price');
            $table->text('description')->nullable()->after('duration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('video_call_prices', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('duration');
            $table->dropColumn('description');
        });
    }
}
