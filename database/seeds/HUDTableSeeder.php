<?php

use Illuminate\Database\Seeder;
use App\Models\HUD;
use App\Models\District;

class HUDTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $districts = District::get();
        $huds = [
            ['name'=>'Aranthangi','district_name'=>'Pudukottai'],
            ['name'=>'Ariyalur','district_name'=>'Ariyalur'],
            ['name'=>'Athur','district_name'=>'Salem'],
            ['name'=>'Chengalpattu','district_name'=>'Chengalpattu'],
            ['name'=>'Cheyyar','district_name'=>'Tiruvannamalai'],
            ['name'=>'Coimbatore','district_name'=>'Coimbatore'],
            ['name'=>'Cuddalore','district_name'=>'Cuddalore'],
            ['name'=>'Dharmapuri','district_name'=>'Dharmapuri'],
            ['name'=>'Dindigul','district_name'=>'Dindigul'],
            ['name'=>'Erode','district_name'=>'Erode'],
            ['name'=>'Kallakurichi','district_name'=>'Kallakurichi'],
            ['name'=>'Kancheepuram','district_name'=>'Kancheepuram'],
            ['name'=>'Karur','district_name'=>'Karur'],
            ['name'=>'Koilpatti','district_name'=>'Tuticorin'],
            ['name'=>'Krishnagiri','district_name'=>'Krishnagiri'],
            ['name'=>'Madurai','district_name'=>'Madurai'],
            ['name'=>'Mayiladuthurai','district_name'=>'Mayiladuthurai'],
            ['name'=>'Nagapattinam','district_name'=>'Nagapattinam'],
            ['name'=>'Nagercoil','district_name'=>'Nagercoil'],
            ['name'=>'Namakkal','district_name'=>'Namakkal'],
            ['name'=>'Palani','district_name'=>'Dindigul'],
            ['name'=>'Paramakudi','district_name'=>'Ramanathapuram'],
            ['name'=>'Perambalur','district_name'=>'Perambalur'],
            ['name'=>'Poonamallee','district_name'=>'Tiruvallur'],
            ['name'=>'Pudukottai','district_name'=>'Pudukottai'],
            ['name'=>'Ramanathapuram','district_name'=>'Ramanathapuram'],
            ['name'=>'Ranipet','district_name'=>'Ranipet'],
            ['name'=>'Salem','district_name'=>'Salem'],
            ['name'=>'Sivaganga','district_name'=>'Sivaganga'],
            ['name'=>'Sivakasi','district_name'=>'Virudhunagar'],
            ['name'=>'Tenkasi','district_name'=>'Tenkasi'],
            ['name'=>'Thanjavur','district_name'=>'Thanjavur'],
            ['name'=>'The Nilgiris','district_name'=>'The Nilgiris'],
            ['name'=>'Theni','district_name'=>'Theni'],
            ['name'=>'Thiruvarur','district_name'=>'Thiruvarur'],
            ['name'=>'Tirunelveli','district_name'=>'Tirunelveli'],
            ['name'=>'Tirupathur','district_name'=>'Tirupathur'],
            ['name'=>'TIRUPPUR','district_name'=>'TIRUPPUR'],
            ['name'=>'Tiruvallur','district_name'=>'Tiruvallur'],
            ['name'=>'Tiruvannamalai','district_name'=>'Tiruvannamalai'],
            ['name'=>'TRICHY','district_name'=>'TRICHY'],
            ['name'=>'Tuticorin','district_name'=>'Tuticorin'],
            ['name'=>'Vellore','district_name'=>'Vellore'],
            ['name'=>'Villupuram','district_name'=>'Villupuram'],
            ['name'=>'Virudhunagar','district_name'=>'Virudhunagar'],
        ];

        foreach ($huds as $key => $hud) {
            $hud['district_id'] = $districts->where('name',$hud['district_name'])->first()->id??0;
            $hud['status'] = _active();
            unset($hud['district_name']);
            HUD::create($hud);
        }
    }
}
