<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniqueCodeToDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('districts', function (Blueprint $table) {
            $table->string('unique_code')->unique()->nullable();
        });
        Schema::table('huds', function (Blueprint $table) {
            $table->string('unique_code')->unique()->nullable();
        });

        Schema::table('blocks', function (Blueprint $table) {
            $table->string('unique_code')->unique()->nullable();
        });

        Schema::table('p_h_c_s', function (Blueprint $table) {
            $table->string('unique_code')->unique()->nullable();
        });

        Schema::table('hsc', function (Blueprint $table) {
            $table->string('unique_code')->unique()->nullable();
        });
        Schema::table('facility_types', function (Blueprint $table) {
            $table->string('unique_code')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
