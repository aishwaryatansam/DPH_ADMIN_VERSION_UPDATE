<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumnFacilityTypeIdInFacilityHierarchyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facility_hierarchy', function (Blueprint $table) {
            $table->unsignedBigInteger('facility_type_id')->nullable();

            $table->foreign('facility_type_id')->references('id')->on('facility_type')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facility_hierarchy', function (Blueprint $table) {
            //
        });
    }
}
