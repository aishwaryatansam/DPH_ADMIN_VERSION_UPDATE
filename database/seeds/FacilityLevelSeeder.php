<?php

use Illuminate\Database\Seeder;

class FacilityLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('facility_level')->insert([
            ['name' => 'state'],
            ['name' => 'district'],
            ['name' => 'hud'],
            ['name' => 'block'],
            ['name' => 'phc'],
            ['name' => 'hsc'],
        ]);
    }
}
