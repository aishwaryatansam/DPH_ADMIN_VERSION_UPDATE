<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsBannerOneTitleBannerTwoTitleBannerThreeTitleInConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->text('mini_banner_one_title')->nullable();
            $table->text('mini_banner_two_title')->nullable();
            $table->text('mini_banner_three_title')->nullable();
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
            $this->dropColumn(['mini_banner_one_title','mini_banner_two_title','mini_banner_three_title']);
        });
    }
}
