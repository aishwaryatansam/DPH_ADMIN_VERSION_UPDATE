<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMiniBannerOneAndMiniBannerTwoInConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->text('mini_banner_one')->nullable();
            $table->text('mini_banner_two')->nullable();
            $table->text('mini_banner_three')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $this->dropColumn(['mini_banner_one','mini_banner_two','mini_banner_three']);
        });
    }
}
