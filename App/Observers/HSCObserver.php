<?php

namespace App\Observers;

use App\Models\HSC;
use App\Helpers\CustomHelper;

class HSCObserver
{
     public function created(HSC $hsc)
    {

        $name = $hsc->name;
        $id = $hsc->id;
        $uniqueCode = generateUniqueCode($name, $id);
        $hsc->unique_code = $uniqueCode;
        $hsc->save();
       
    }
}
