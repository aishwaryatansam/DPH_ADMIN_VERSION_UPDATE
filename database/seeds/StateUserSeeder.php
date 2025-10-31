<?php

use App\Models\Program;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fetch all programs and sections
        $programs = Program::all();
        $sections = Section::all();

        // Iterate through programs to create admin and verifier users
        foreach ($programs as $program) {
            $shortCode = $program->short_code;

            // Create admin user (user_role_id = 1)
            User::create([
                'name' => null,
                'email' => null,
                'username' => "{$shortCode}_APPROVER",
                'password' => Hash::make('tndphpm@123'), // Use a secure default password
                'user_type_id' => 1,
                'contact_number' => null,
                'country_code' => null,
                'otp' => null,
                'last_otp_verified_at' => null,
                'status' => 1,
                'section' => null,
                'designation' => null,
                'facility_hierarchy_id' => null,
                'user_role_id' => 1,
                'programs_id' => $program->id,
                'sections_id' => null,
                'designations_id' => null,
            ]);

            // Create verifier user (user_role_id = 2)
            User::create([
                'name' => null,
                'email' => null,
                'username' => "{$shortCode}_VERIFIER",
                'password' => Hash::make('tndphpm@123'), // Use a secure default password
                'user_type_id' => 1,
                'contact_number' => null,
                'country_code' => null,
                'otp' => null,
                'last_otp_verified_at' => null,
                'status' => 1,
                'section' => null,
                'designation' => null,
                'facility_hierarchy_id' => null,
                'user_role_id' => 2,
                'programs_id' => $program->id,
                'sections_id' => null,
                'designations_id' => null,
            ]);
        }

        // Iterate through sections to create general users
        foreach ($sections as $section) {
            $shortCode = $section->short_code;

            User::create([
                'name' => null,
                'email' => null,
                'username' => "{$shortCode}_User",
                'password' => Hash::make('tndphpm@123'), // Use a secure default password
                'user_type_id' => 1,
                'contact_number' => null,
                'country_code' => null,
                'otp' => null,
                'last_otp_verified_at' => null,
                'status' => 1,
                'designation' => null,
                'facility_hierarchy_id' => null,
                'user_role_id' => 3,
                'programs_id' => null,
                'sections_id' => $section->id,
                'designations_id' => null,
            ]);
        }
    }
}
