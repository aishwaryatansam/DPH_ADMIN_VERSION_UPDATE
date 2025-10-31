<?php

namespace App\Observers;

use App\Models\District;
use App\Helpers\CustomHelper;

class DistrictObserver
{
    public function created(District $district)
    {

        $name = $district->name;
        $id = $district->id;
        $uniqueCode = generateUniqueCode($name, $id);
        $district->unique_code = $uniqueCode;
        $district->save();
 
    }
}
