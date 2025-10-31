<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateFacilityIdInContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Step 1: Get all contacts where facility_id is null
         $contacts = DB::table('contacts')->whereNull('facility_id')->get();

         foreach ($contacts as $contact) {
             $facility_id = null;
 
             // Step 2: Determine the facility_id based on contact_type
             switch ($contact->contact_type) {
                 case 4: // HUD
                     $facility_id = DB::table('facility_hierarchy')
                         ->where('hud_id', $contact->hud_id)
                         ->where('facility_level_id', 3)
                         ->value('id');
                     break;
                 case 9: // PHC
                     $facility_id = DB::table('facility_hierarchy')
                         ->where('phc_id', $contact->phc_id)
                         ->where('facility_level_id', 5)
                         ->value('id');
                     break;
                 case 8: // Block
                     $facility_id = DB::table('facility_hierarchy')
                         ->where('block_id', $contact->block_id)
                         ->where('facility_level_id', 4)
                         ->value('id');
                     break;
                 case 10: // HSC
                     $facility_id = DB::table('facility_hierarchy')
                         ->where('hsc_id', $contact->hsc_id)
                         ->where('facility_level_id', 6)
                         ->value('id');
                     break;
             }
 
             // Step 3: Update the facility_id in contacts table
             if ($facility_id) {
                 DB::table('contacts')
                     ->where('id', $contact->id)
                     ->update(['facility_id' => $facility_id]);
             }
         }
    }
}
