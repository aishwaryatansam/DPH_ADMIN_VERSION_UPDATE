<?php

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
        	['name' => 'India','country_code'=>'+91','status'=>_active()]
        ];

        foreach ($countries as $key => $country) {
        	Country::create($country);
        }
        
    }
}
