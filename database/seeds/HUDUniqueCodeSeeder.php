<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\HUD;

class HUDUniqueCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $huds = HUD::all();

        foreach ($huds as $hud){

        	$slugKey = Str::slug(str_replace(' ', '', $hud->name));

        	$uniqueCode = $slugKey . str_pad($hud->id, 5, '0', STR_PAD_LEFT);

        	$hud->update(['unique_code' => $uniqueCode]);
        }
    }
}

