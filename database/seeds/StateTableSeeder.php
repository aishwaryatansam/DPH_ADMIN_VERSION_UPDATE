<?php

use Illuminate\Database\Seeder;
use App\Models\State;

class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = [
        	['name' => 'Tamilnadu','country_id'=>1,'status'=>_active()]
        ];

        foreach ($states as $key => $state) {
        	State::create($state);
        }
    }
}
