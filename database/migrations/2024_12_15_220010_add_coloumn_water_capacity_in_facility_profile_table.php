<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumnWaterCapacityInFacilityProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facility_profile', function (Blueprint $table) {
            $table->text('water_capacity')->nullable();
            $table->text('ro_capacity')->nullable();
            $table->text('generator_capacity')->nullable();
            $table->text('generator_year_installation')->nullable();
            $table->text('power_kva')->nullable();
            $table->text('power_year_installation')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facility_profile', function (Blueprint $table) {
            //
        });
    }
}
