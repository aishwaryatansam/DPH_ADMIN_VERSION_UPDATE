<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HudUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all facilities with facility_level_id = 3 (HUD level)
        $facilities = DB::table('facility_hierarchy')
            ->where('facility_level_id', 3)
            ->get();

        foreach ($facilities as $facility) {
            // Define roles and their corresponding suffix for the username
            $roles = [
                1 => 'approver',
                2 => 'verifier',
                3 => 'user',
            ];

            foreach ($roles as $user_role_id => $role_suffix) {
                // Create a user for each role
                DB::table('users')->insert([
                    'name' => ucfirst($role_suffix) . ' for ' . $facility->facility_name,
                    'email' => strtolower($facility->facility_name) . '.' . $role_suffix . '@example.com',
                    'username' => strtolower($facility->facility_name) . '_' . $role_suffix . '_' . $facility->id,
                    'password' => Hash::make('tndphpm@123'), // Default password, change as needed
                    'user_type_id' => 3, // Set to user_type_id = 3
                    'contact_number' => null,
                    'country_code' => null,
                    'otp' => null,
                    'last_otp_verified_at' => null,
                    'status' => 1,
                    'section' => null,
                    'designation' => null,
                    'facility_hierarchy_id' => $facility->id, // Associate with the facility
                    'user_role_id' => $user_role_id, // Role ID (1, 2, or 3)
                    'programs_id' => null,
                    'sections_id' => null,
                    'designations_id' => null,
                ]);
            }
        }
    }
}
