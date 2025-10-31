<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacilityBuildingDetails extends Model
{
    protected $table = 'facility_building_details';

    protected $fillable = [
        'building_status',
        'own_go_ms_no_pdf_path',
        'own_go_ms_no',
        'own_date',
        'own_total_amount',
        'rent_free_allocated_by',
        'rent_free_date',
        'rent_free_no_of_years',
        'rent_free_permission_letter',
        'rented_payment_frequency',
        'rented_amount',
        'rented_lease_document_path',
        'public_allocated_by',
        'public_date',
        'public_no_of_years',
        'public_permission_letter',
        'under_construction_type',
        'under_construction_images',
        'electricity_status',
        'electricity_wiring_status',
        'electricity_fittings_fans',
        'electricity_fittings_lights',
        'electricity_fittings_normals',
        'water_connected',
        'water_connection_details',
        'water_connection_date',
        'carpentry_doors',
        'carpentry_windows',
        'carpentry_cupboards',
        'source_of_funding',
        'building_paint_status',
        'paint_incomplete_type',
        'work_completed_status',
        'work_completed_by',
        'work_completed_details',
        'work_completed_date',
        'inauguration_status',
        'inauguration_by',
        'inauguration_date',
        'inauguration_images',
        'ready_current_images',
        'ready_who_inaugurate',
        'ready_inaugurate_fixed_date',
        'culvert_status',
        'culvert_date_of_installation',
        'culvert_image_path',
        'handed_over',
        'handed_over_type',
        'handed_over_whom',
        'handed_over_date',
        'occupied_date',
        'compound_wall_status',
        'water_tank_status',
        'water_tank_capacity',
        'sump_status',
        'sump_capacity',
        'oht_status',
        'oht_capacity',
        'ro_water_availability',
        'ro_water_make',
        'ro_water_capacity',
        'approach_road_status',
        'approach_road_type',
        'electric_connections',
        'additional_power_source',
        'power_type',
        'generator_make',
        'generator_capacity',
        'generator_year_of_installation',
        'ups_make',
        'ups_capacity',
        'ups_year_of_installation',
        'internet_connection',
        'internet_brand_name',
        'internet_payment_frequency',
        'internet_payment_cost',
        'landline_connection',
        'landline_service_provider',
        'landline_location',
        'landline_plan_details',
        'landline_payment_frequency',
        'landline_payment_cost',
        'fax_connection',
        'fax_service_provider',
        'fax_location',
        'fax_plan_details',
        'fax_payment_frequency',
        'fax_payment_cost',
        'facility_profile_id',
        'electric_service_number', 
        'is_active'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ];

    public function getCreatedAtAttribute($date)
    {
        return convertUTCToLocal($date);
    }

    public function getUpdatedAtAttribute($date)
    {
        return convertUTCToLocal($date);
    }


    public function facility_profile()
    {
        return $this->belongsTo(FacilityProfile::class, 'facility_profile_id');
    }

}
