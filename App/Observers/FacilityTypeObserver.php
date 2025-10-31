<?php

namespace App\Observers;

use App\Models\FacilityType;
use App\Helpers\CustomHelper;

class FacilityTypeObserver
{
    public function created(FacilityType $facilityType)
    {

        $name = $facilityType->name;
        $id = $facilityType->id;
        $facilityType->save();
 
    }
}
