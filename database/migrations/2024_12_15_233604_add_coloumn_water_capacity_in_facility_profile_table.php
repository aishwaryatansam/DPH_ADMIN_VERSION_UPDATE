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
        Schema::table('facility_images', function (Blueprint $table) {
            $table->unsignedSmallInteger('under_construction_status')->nullable()->after('image_type');

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
