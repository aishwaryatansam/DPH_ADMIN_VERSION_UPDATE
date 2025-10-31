<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacilityHierarchyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facility_hierarchy', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('facility_name');
            $table->string('facility_code')->unique(); // Unique code for each facility
            $table->unsignedBigInteger('facility_level_id');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('hud_id')->nullable();
            $table->unsignedBigInteger('block_id')->nullable();
            $table->unsignedBigInteger('phc_id')->nullable();
            $table->unsignedBigInteger('hsc_id')->nullable();
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('facility_level_id')->references('id')->on('facility_level')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('set null');
            $table->foreign('hud_id')->references('id')->on('huds')->onDelete('set null');
            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('set null');
            $table->foreign('phc_id')->references('id')->on('p_h_c_s')->onDelete('set null');
            $table->foreign('hsc_id')->references('id')->on('hsc')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facility_hierarchy');
    }
}
