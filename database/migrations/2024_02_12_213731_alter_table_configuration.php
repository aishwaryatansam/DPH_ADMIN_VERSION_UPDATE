<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableConfiguration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('homepage_banner_one_status')->default(0);
            $table->boolean('homepage_banner_two_status')->default(0);
            $table->boolean('homepage_banner_three_status')->default(0);
            $table->boolean('homepage_banner_four_status')->default(0);
            $table->boolean('homepage_banner_five_status')->default(0);
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
            $table->dropColumn('homepage_banner_one_status');
            $table->dropColumn('homepage_banner_two_status');
            $table->dropColumn('homepage_banner_three_status');
            $table->dropColumn('homepage_banner_four_status');
            $table->dropColumn('homepage_banner_five_status');
        });
    }
}
