<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumnRentFreePermissionLetterInFacilityBuildingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facility_building_details', function (Blueprint $table) {
            $table->string('rent_free_permission_letter')->nullable()->after('rent_free_no_of_years');
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
