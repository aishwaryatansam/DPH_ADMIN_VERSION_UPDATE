<?php

use Illuminate\Database\Seeder;
use App\Models\QuantityType;

class QuantityTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $quantityTypes = [

        	['name'=> 'Unit', 'short_code' =>'no(s)'],
        	['name'=> 'Litre', 'short_code' =>'ltr'],
        	['name'=> 'Milli Litre', 'short_code' =>'ml'],
        	['name'=> 'Gram', 'short_code' =>'g'],
        	['name'=> 'Kilo Gram', 'short_code' =>'kg'],
        	['name'=> 'Piece(s)', 'short_code' =>'piece(s)'],
        	['name'=> 'Box', 'short_code' =>'box'],
        	['name'=> 'Boxes', 'short_code' =>'boxes'],
        	['name'=> 'Pack(s)', 'short_code' =>'pack(s)'],
        	['name'=> 'Quantity', 'short_code' =>'Qty'],
        ];

        foreach ($quantityTypes as $key => $quantityType) {
        	
        	$quantityType['status'] = _active();

        	QuantityType::create($quantityType);
        }
    }
}
