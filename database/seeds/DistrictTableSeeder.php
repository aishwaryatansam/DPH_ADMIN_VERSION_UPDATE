<?php

use Illuminate\Database\Seeder;
use App\Models\District;

class DistrictTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $districts = [
            ['name'=>'Ariyalur'],
            ['name'=>'Chengalpattu'],
            ['name'=>'Coimbatore'],
            ['name'=>'Cuddalore'],
            ['name'=>'Dharmapuri'],
            ['name'=>'Dindigul'],
            ['name'=>'Erode'],
            ['name'=>'Kallakurichi'],
            ['name'=>'Kancheepuram'],
            ['name'=>'Karur'],
            ['name'=>'Krishnagiri'],
            ['name'=>'Madurai'],
            ['name'=>'Mayiladuthurai'],
            ['name'=>'Nagapattinam'],
            ['name'=>'Nagercoil'],
            ['name'=>'Namakkal'],
            ['name'=>'Perambalur'],
            ['name'=>'Pudukottai'],
            ['name'=>'Ramanathapuram'],
            ['name'=>'Ranipet'],
            ['name'=>'Salem'],
            ['name'=>'Sivaganga'],
            ['name'=>'Tenkasi'],
            ['name'=>'Thanjavur'],
            ['name'=>'The Nilgiris'],
            ['name'=>'Theni'],
            ['name'=>'Thiruvarur'],
            ['name'=>'Tirunelveli'],
            ['name'=>'Tirupathur'],
            ['name'=>'TIRUPPUR'],
            ['name'=>'Tiruvallur'],
            ['name'=>'Tiruvannamalai'],
            ['name'=>'TRICHY'],
            ['name'=>'Tuticorin'],
            ['name'=>'Vellore'],
            ['name'=>'Villupuram'],
            ['name'=>'Virudhunagar'],
        ];

        foreach ($districts as $key => $district) {
            $district['status'] = _active();
            District::create($district);
        }
    }
}
