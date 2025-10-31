<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacilityProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facility_profile', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('facility_hierarchy_id')->nullable();
            $table->text('address_line1')->nullable();
            $table->text('address_line2')->nullable();
            $table->text('pincode')->nullable();
            $table->text('latitude')->nullable();
            $table->text('longitude')->nullable();
            $table->text('video_url')->nullable();
            $table->text('abdm_facility_number')->nullable();
            $table->text('nin_number')->nullable();
            $table->text('picme')->nullable();
            $table->text('hmis')->nullable();

            $table->foreign('facility_hierarchy_id')->references('id')->on('facility_hierarchy')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facility_profile');
    }
}
