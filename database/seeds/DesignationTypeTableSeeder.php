<?php

use Illuminate\Database\Seeder;
use App\Models\DesignationType;

class DesignationTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $designationTypes= [
            ['name'=> 'Common', 'slug_key' => 'common'],
            ['name'=> 'State', 'slug_key' => 'state'],
            ['name'=> 'District', 'slug_key' => 'district'],
            ['name'=> 'HUD', 'slug_key' => 'hud'],
            ['name'=> 'IVCZ', 'slug_key' => 'ivcz'],
            ['name'=> 'Other 1', 'slug_key' => 'other_1'],
            ['name'=> 'Other 2', 'slug_key' => 'other_2'],
            ['name'=> 'Block', 'slug_key' => 'block'],
            ['name'=> 'PHC', 'slug_key' => 'phc'],
            ['name'=> 'HSC', 'slug_key' => 'hsc'],
        ];

        foreach ($designationTypes as $key => $designationType) {

            $designationType['status'] = _active();

            DesignationType::create($designationType);
        }
    }
}
