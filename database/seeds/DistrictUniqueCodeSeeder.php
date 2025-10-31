<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\District;

class DistrictUniqueCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $districts = District::all();

        foreach ($districts as $district){

        	$slugKey = Str::slug(str_replace(' ', '', $district->name));

        	$uniqueCode = $slugKey . str_pad($district->id, 5, '0', STR_PAD_LEFT);

        	//District::where('id', $district->id)->update(['unique_code' => $uniqueCode]); 
        	$district->update(['unique_code'=> $uniqueCode]);
        }

    }
}

