<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacilityProfileContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contacts = DB::table('contacts')->get();

        foreach ($contacts as $contact) {
            $facilityProfile = DB::table('facility_profile')
                ->where('facility_hierarchy_id', $contact->facility_id)
                ->first();

            if ($facilityProfile) {
                DB::table('facility_profile')
                    ->where('id', $facilityProfile->id)
                    ->update([
                        'mobile_number' => $contact->mobile_number,
                        'landline_number' => $contact->landline_number,
                        'email_id' => $contact->email_id,
                        'fax' => $contact->fax,
                        'updated_at' => now(),
                    ]);
            }
        }


        // DB::table('facility_hierarchy')->orderBy('id')->chunk(1000, function ($facilityHierarchies) {
        //     foreach ($facilityHierarchies as $facilityHierarchy) {
        //         // Update the matching facility_profile record
        //         DB::table('facility_profile')
        //             ->where('facility_hierarchy_id', $facilityHierarchy->id)
        //             ->update([
        //                 'area_type' => $facilityHierarchy->area_type,
        //                 'updated_at' => now(), // Update the timestamp
        //             ]);
        //     }
        // });
    }
}
