<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\FacilityType;

class FacilityTypeUniqueCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $facilityTypes = FacilityType::all();

        foreach ($facilityTypes as $facilityType){

        	$slugKey = Str::slug(str_replace(' ', '', $facilityType->name));

        	$uniqueCode = $slugKey . str_pad($facilityType->id, 5, '0', STR_PAD_LEFT);

        	$facilityType->update(['unique_code' => $uniqueCode]);
        }
    }
}

