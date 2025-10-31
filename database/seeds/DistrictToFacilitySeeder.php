<?php

use App\Models\Block;
use Illuminate\Database\Seeder;
use App\Models\District;
use App\Models\FacilityHierarchy;
use App\Models\HSC;
use App\Models\HUD;
use App\Models\PHC;

class DistrictToFacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hscs = HSC::all();

        foreach ($hscs as $hsc) {
            // Insert each district into the facility_hierarchy table
            FacilityHierarchy::create([
                'facility_name' => $hsc->name,  // District name goes into facility_name,
                'district_id' => $hsc->phc->block->hud->district_id,      // District ID goes into district_id
                'hud_id' => $hsc->phc->block->hud_id,
                'block_id' => $hsc->phc->block_id,
                'phc_id' => $hsc->phc_id,
                'hsc_id' => $hsc->id,
                'country_id' => 1,                   // Example: You can set a default country/state if needed
                'state_id' => 1,
                'facility_level_id' => 6,
                // Add other fields as needed or set default values
            ]);
        }
    }
}
