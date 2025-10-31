<?php

use App\Models\FacilityBuildingDetails;
use App\Models\FacilityProfile;
use Illuminate\Database\Seeder;

class FacilityBuildingDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $facilityProfiles = FacilityProfile::pluck('id'); // Collect facility_profile IDs

        $data = $facilityProfiles->map(function ($id) {
            return [
                'facility_profile_id' => $id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();


        FacilityBuildingDetails::insert($data); // Insert into facility_building_details

    }
}
