<?php

use Illuminate\Database\Seeder;

class ConfigurationContentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contentTypes = [
            ['name' => 'Header Logo', 'status' => 1],
            ['name' => 'Header Banner', 'status' => 1],
            ['name' => 'Partner Links', 'status' => 1],
            ['name' => 'Footer Logo', 'status' => 1],
            ['name' => 'Social Media', 'status' => 1],
            ['name' => 'Important Links', 'status' => 1],
            ['name' => 'Quick Links', 'status' => 1],
            ['name' => 'Public', 'status' => 1],
            ['name' => 'Resource', 'status' => 1],
            ['name' => 'Emergency Contact', 'status' => 1],
        ];

        DB::table('configuration_content_type')->insert($contentTypes);
    }
}
