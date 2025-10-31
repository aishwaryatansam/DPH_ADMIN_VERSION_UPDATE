<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\HSC;

class HSCUniqueCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $hscs = HSC::all();

        foreach ($hscs as $hsc){

        	$slugKey = Str::slug(str_replace(' ', '', $hsc->name));

        	$uniqueCode = $slugKey . str_pad($hsc->id, 5, '0', STR_PAD_LEFT);

        	$hsc->update(['unique_code' => $uniqueCode]);
        }
    }
}

