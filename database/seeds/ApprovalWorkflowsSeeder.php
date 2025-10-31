<?php

use App\Models\ApprovalWorkflows;
use App\Models\FacilityProfile;
use App\Models\NewDocument;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApprovalWorkflowsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $facilityProfiles = DB::table('facility_profile')->get();

        // Iterate through each facility profile record
        foreach ($facilityProfiles as $profile) {
            ApprovalWorkflows::create([
                'model_type' => FacilityProfile::class,
                'model_id' => $profile->id,
                'uploaded_by' => 1, // Default uploaded_by value
                'current_stage' => 'published', // Default current_stage value
                'remarks' => null, // Add remarks if needed
            ]);
        }

        // $newDocuments = DB::table('new_documents')->get();

        // foreach ($newDocuments as $newDocument) {
        //     ApprovalWorkflows::create([
        //         'model_type' => NewDocument::class,
        //         'model_id' => $newDocument->id,
        //         'uploaded_by' => 222, // Default uploaded_by value
        //         'current_stage' => 'state_upload', // Default current_stage value
        //         'remarks' => null, // Add remarks if needed
        //     ]);
        // }

        // $contacts = DB::table('contacts')->get();

        // foreach ($contacts as $contact) {
        //     ApprovalWorkflows::create([
        //         'model_type' => NewDocument::class,
        //         'model_id' => $contact->id,
        //         'uploaded_by' => 222, // Default uploaded_by value
        //         'current_stage' => 'state_upload', // Default current_stage value
        //         'remarks' => null, // Add remarks if needed
        //     ]);
        // }

    }
}
