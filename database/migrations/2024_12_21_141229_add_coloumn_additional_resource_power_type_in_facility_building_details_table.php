<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use function PHPUnit\Framework\MockObject\Builder\after;

class AddColoumnAdditionalResourcePowerTypeInFacilityBuildingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facility_building_details', function (Blueprint $table) {
            $table->enum('power_type', ['generator', 'ups'])->after('additional_power_source');
            
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
