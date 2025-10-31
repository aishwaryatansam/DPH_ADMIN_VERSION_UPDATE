<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumnElectricServiceNumberInFacilityBuildingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facility_building_details', function (Blueprint $table) {
            $table->string('electric_service_number')->nullable()->after('under_construction_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facility_building_details', function (Blueprint $table) {
            //
        });
    }
}
