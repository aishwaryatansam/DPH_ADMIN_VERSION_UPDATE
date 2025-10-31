<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnLocationUrlToDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('districts', function (Blueprint $table) {
            $table->text('location_url')->nullable();
        });

        Schema::table('huds', function (Blueprint $table) {
            $table->text('location_url')->nullable();
        });

        Schema::table('blocks', function (Blueprint $table) {
            $table->text('location_url')->nullable();
        });

        Schema::table('p_h_c_s', function (Blueprint $table) {
            $table->text('location_url')->nullable();
        });

        Schema::table('hsc', function (Blueprint $table) {
            $table->text('location_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        return;
        Schema::table('districts', function (Blueprint $table) {
            $table->dropColumn(['location_url'])->nullable();
        });
        Schema::table('huds', function (Blueprint $table) {
            $table->dropColumn(['location_url'])->nullable();
        });

        Schema::table('blocks', function (Blueprint $table) {
            $table->dropColumn(['location_url'])->nullable();
        });

        Schema::table('p_h_c_s', function (Blueprint $table) {
            $table->dropColumn(['location_url'])->nullable();
        });

        Schema::table('hsc', function (Blueprint $table) {
            $table->dropColumn(['location_url'])->nullable();
        });
    }
}
