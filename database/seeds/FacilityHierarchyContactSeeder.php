<?php

use App\Models\Contact;
use App\Models\FacilityHierarchy;
use Illuminate\Database\Seeder;

class FacilityHierarchyContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contacts = Contact::all();
        foreach ($contacts as $contact) {
            // Check contact_type and build the query based on the type
            switch ($contact->contact_type) {
                case 4: // HUD type, only match hud_id
                    $facilityHierarchy = FacilityHierarchy::where('hud_id', $contact->hud_id)
                    ->where('facility_level_id', 3)
                    ->first();
                    break;

                case 2: // State type
                case 5: // IVCZ type
                case 8: // Block type
                    $facilityHierarchy = FacilityHierarchy::where('hud_id', $contact->hud_id)
                        ->where('block_id', $contact->block_id)
                        ->where('facility_level_id', 4)
                        ->first();
                        break;
                case 9: // PHC type
                    $facilityHierarchy = FacilityHierarchy::where('hud_id', $contact->hud_id)
                        ->where('block_id', $contact->block_id)
                        ->where('phc_id', $contact->phc_id)
                        ->where('facility_level_id', 5)
                        ->first();
                        break;
                case 10: // HSC type
                    // For these types, we use the relevant IDs
                    $facilityHierarchy = FacilityHierarchy::where('hud_id', $contact->hud_id)
                        ->where('block_id', $contact->block_id)
                        ->where('phc_id', $contact->phc_id)
                        ->where('hsc_id', $contact->hsc_id)
                        ->where('facility_level_id', 6)
                        ->first();
                    break;

                default:
                    $facilityHierarchy = null;
                    break;
            }

            // If a matching facility_hierarchy is found, update the facility_hierarchy_id in the contact
            if ($facilityHierarchy) {
                $contact->facility_id = $facilityHierarchy->id;
                $contact->save();
            }
        }
    }
}
