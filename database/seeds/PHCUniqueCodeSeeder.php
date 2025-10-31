<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\PHC;

class PHCUniqueCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $phcs = PHC::all();

        foreach ($phcs as $phc){

        	$slugKey = Str::slug(str_replace(' ', '', $phc->name));

        	$uniqueCode = $slugKey . str_pad($phc->id, 5, '0', STR_PAD_LEFT);

        	$phc->update(['unique_code' => $uniqueCode]);
        }
    }
}

