<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacilityProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $facilityHierarchy = DB::table('facility_hierarchy')->get();

        foreach ($facilityHierarchy as $facility) {
            $videoUrl = null;
            $imageUrl = null;
            $documentUrl = null;
            $locationUrl = null;

            switch ($facility->facility_level_id) {

                case 2: // District level
                    $district = DB::table('districts')->where('id', $facility->district_id)->first();
                    if ($district) {
                        $imageUrl = $district->image_url;
                        $locationUrl = $district->location_url;
                    }
                    break;

                case 3: // HUD level
                    $hud = DB::table('huds')->where('id', $facility->hud_id)->first();
                    if ($hud) {
                        $videoUrl = $hud->video_url;
                        $imageUrl = $hud->image_url;
                        $documentUrl = $hud->property_document_url;
                        $locationUrl = $hud->location_url;
                    }
                    break;

                case 4: // Block level
                    $block = DB::table('blocks')->where('id', $facility->block_id)->first();
                    if ($block) {
                        $videoUrl = $block->video_url;
                        $imageUrl = $block->image_url;
                        $documentUrl = $block->property_document_url;
                        $locationUrl = $block->location_url;
                    }
                    break;

                case 5: // PHC level
                    $phc = DB::table('p_h_c_s')->where('id', $facility->phc_id)->first();
                    if ($phc) {
                        $videoUrl = $phc->video_url;
                        $imageUrl = $phc->image_url;
                        $documentUrl = $phc->property_document_url;
                        $locationUrl = $phc->location_url;
                    }
                    break;

                case 6: // HSC level
                    $hsc = DB::table('hsc')->where('id', $facility->hsc_id)->first();
                    if ($hsc) {
                        $videoUrl = $hsc->video_url;
                        $imageUrl = $hsc->image_url;
                        $documentUrl = $hsc->property_document_url;
                        $locationUrl = $hsc->location_url;
                    }
                    break;

                // Add more levels if necessary
            }

            $facilityProfileId = DB::table('facility_profile')->insertGetId([
                'facility_hierarchy_id' => $facility->id,
                'video_url' => $videoUrl,
                'location_url' => $locationUrl,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($imageUrl) {
                DB::table('facility_images')->insert([
                    'facility_profile_id' => $facilityProfileId,
                    'image_url' => $imageUrl,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if ($documentUrl) {
                DB::table('facility_documents')->insert([
                    'facility_profile_id' => $facilityProfileId,
                    'document_url' => $documentUrl,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

        }


    }
}
