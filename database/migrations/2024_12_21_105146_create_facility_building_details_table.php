<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacilityBuildingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facility_building_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('facility_profile_id')->nullable();
            
            $table->enum('building_status', ['own', 'rent_free', 'rented', 'public_building', 'under_construction']);

            // Fields for 'own'
            $table->string('own_go_ms_no_pdf_path')->nullable();
            $table->string('own_go_ms_no')->nullable();
            $table->date('own_date')->nullable();
            $table->string('own_total_amount')->nullable();

            // Fields for 'rent_free'
            $table->string('rent_free_allocated_by')->nullable();
            $table->date('rent_free_date')->nullable();
            $table->string('rent_free_no_of_years')->nullable();

            // Fields for 'rented'
            $table->enum('rented_payment_frequency', ['monthly', 'quarterly', 'lease'])->nullable();
            $table->decimal('rented_amount', 15, 2)->nullable();
            $table->string('rented_lease_document_path')->nullable();

            // Fields for 'public_building'
            $table->string('public_allocated_by')->nullable();
            $table->date('public_date')->nullable();
            $table->integer('public_no_of_years')->nullable();

            // Fields for 'under_construction'
            $table->enum('under_construction_type', ['land_identified', 'basement_level', 'wall_level', 'lintel_level', 'roof_level', 'g_work_started', 'support_service'])->nullable();
            $table->enum('electricity_wiring_status', ['completed', 'partial', 'not_completed'])->nullable();
            $table->integer('electricity_fittings_fans')->nullable();
            $table->integer('electricity_fittings_lights')->nullable();
            $table->integer('electricity_fittings_leds:')->nullable();
            $table->integer('electricity_fittings_normals')->nullable();
            $table->boolean('water_connected')->nullable();
            $table->string('water_connection_details')->nullable();
            $table->date('water_connection_date')->nullable();
            $table->integer('carpentry_doors')->nullable();
            $table->integer('carpentry_windows')->nullable();
            $table->integer('carpentry_cupboards')->nullable();

            // Fields for source of funding
            $table->json('source_of_funding')->nullable();

            // Fields for building paint status
            $table->enum('building_paint_status', ['completed', 'not_yet', 'incomplete'])->nullable();
            $table->enum('paint_incomplete_type', ['indoor', 'outdoor', 'weather_proofing'])->nullable();

            // Fields for work completed status
            $table->boolean('work_completed_status')->nullable();
            $table->enum('work_completed_by', ['pwd', 'private_concern'])->nullable();
            $table->string('work_completed_details')->nullable();
            $table->date('work_completed_date')->nullable();

            // Fields for inauguration status
            $table->enum('inauguration_status', ['completed', 'ready', 'not_fixed'])->nullable();
            $table->string('inauguration_by')->nullable();
            $table->date('inauguration_date')->nullable();
            $table->json('inauguration_images')->nullable();
            $table->json('ready_current_images')->nullable();
            $table->string('ready_who_inaugurate')->nullable();
            $table->date('ready_inaugurate_fixed_date')->nullable();

            // Fields for culvert status
            $table->boolean('culvert_status')->nullable();
            $table->date('culvert_date_of_installation')->nullable();
            $table->string('culvert_image_path')->nullable();

            // Fields for handed over / occupied
            $table->boolean('handed_over')->nullable();
            $table->enum('handed_over_type', ['pwd', 'others'])->nullable();
            $table->string('handed_over_whom')->nullable();
            $table->date('handed_over_date')->nullable();
            $table->date('occupied_date')->nullable();

            // Fields for compound wall
            $table->enum('compound_wall_status', ['fully', 'partial'])->nullable();

            // Fields for water storage facilities
            $table->boolean('water_tank_status')->nullable();
            $table->integer('water_tank_capacity')->nullable();
            $table->boolean('sump_status')->nullable();
            $table->integer('sump_capacity')->nullable();
            $table->boolean('oht_status')->nullable();
            $table->integer('oht_capacity')->nullable();

            // Fields for RO water availability
            $table->boolean('ro_water_availability')->nullable();
            $table->string('ro_water_make')->nullable();
            $table->integer('ro_water_capacity')->nullable();

            // Fields for approach road
            $table->boolean('approach_road_status')->nullable();
            $table->enum('approach_road_type', ['bituminous', 'concrete'])->nullable();

            // Fields for electric connection
            $table->json('electric_connections')->nullable();

            // Fields for additional power source
            $table->boolean('additional_power_source')->nullable();
            $table->string('generator_make')->nullable();
            $table->decimal('generator_capacity', 10, 2)->nullable();
            $table->year('generator_year_of_installation')->nullable();
            $table->string('ups_make')->nullable();
            $table->decimal('ups_capacity', 10, 2)->nullable();
            $table->year('ups_year_of_installation')->nullable();

            // Fields for internet connection
            $table->boolean('internet_connection')->nullable();
            $table->string('internet_brand_name')->nullable();
            $table->enum('internet_payment_frequency', ['monthly', 'six_month', 'yearly'])->nullable();
            $table->decimal('internet_payment_cost', 15, 2)->nullable();

            // Fields for landline connection
            $table->boolean('landline_connection')->nullable();
            $table->string('landline_service_provider')->nullable();
            $table->string('landline_location')->nullable();
            $table->string('landline_plan_details')->nullable();
            $table->enum('landline_payment_frequency', ['monthly', 'quarterly', 'yearly'])->nullable();
            $table->decimal('landline_payment_cost', 15, 2)->nullable();

            // Fields for fax connection
            $table->boolean('fax_connection')->nullable();
            $table->string('fax_service_provider')->nullable();
            $table->string('fax_location')->nullable();
            $table->string('fax_plan_details')->nullable();
            $table->enum('fax_payment_frequency', ['monthly', 'quarterly', 'yearly'])->nullable();
            $table->decimal('fax_payment_cost', 15, 2)->nullable();

            $table->foreign('facility_profile_id')->references('id')->on('facility_profile')->onDelete('cascade');
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
        Schema::dropIfExists('facility_building_details');
    }
}
