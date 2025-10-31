<?php

namespace App\Observers;

use App\Models\PHC;
use App\Helpers\CustomHelper;

class PHCObserver
{ 
    public function created(PHC $phc)
    {

        $name = $phc->name;
        $id = $phc->id;
        $uniqueCode = generateUniqueCode($name, $id);
        $phc->unique_code = $uniqueCode;
        $phc->save();
     
    }
}
