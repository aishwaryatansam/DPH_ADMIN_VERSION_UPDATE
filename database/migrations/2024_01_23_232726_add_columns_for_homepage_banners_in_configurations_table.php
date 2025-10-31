<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsForHomepageBannersInConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->string('homepage_banner_one_title')->nullable();
            $table->string('homepage_banner_two_title')->nullable();
            $table->string('homepage_banner_three_title')->nullable();
            $table->string('homepage_banner_four_title')->nullable();
            $table->string('homepage_banner_five_title')->nullable();
            $table->text('homepage_banner_one')->nullable();
            $table->text('homepage_banner_two')->nullable();
            $table->text('homepage_banner_three')->nullable();
            $table->text('homepage_banner_four')->nullable();
            $table->text('homepage_banner_five')->nullable();
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
            $table->dropColumn('homepage_banner_one_title');
            $table->dropColumn('homepage_banner_two_title');
            $table->dropColumn('homepage_banner_three_title');
            $table->dropColumn('homepage_banner_four_title');
            $table->dropColumn('homepage_banner_five_title');
            $table->dropColumn('homepage_banner_one');
            $table->dropColumn('homepage_banner_two');
            $table->dropColumn('homepage_banner_three');
            $table->dropColumn('homepage_banner_four');
            $table->dropColumn('homepage_banner_five');
        });
    }
}
