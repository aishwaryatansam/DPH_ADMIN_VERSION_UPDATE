<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumnBuildingStatusInFacilityProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facility_profile', function (Blueprint $table) {
            $table->unsignedSmallInteger('building_status')->nullable();
            $table->text('source_of_funding')->nullable();
            $table->date('date_of_inauguration')->nullable();
            $table->text('inaugurated_by')->nullable();
            $table->boolean('culvert_status')->default(0);
            $table->date('date_of_occupation')->nullable();
            $table->text('compound_wall')->nullable();
            $table->boolean('water_tank_availability')->default(0);
            $table->boolean('ro_availability')->default(0);
            $table->boolean('generator_ups_availability')->default(0);
            $table->boolean('power_lt_ht_availability')->default(0);
            $table->unsignedSmallInteger('construction_status')->nullable();


            $table->index(['building_status','construction_status']);
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
