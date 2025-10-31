<?php

namespace App\Observers;
use App\Models\HUD;
use App\Models\User;
use App\Models\Contact;
use App\Helpers\CustomHelper;

class HUDObserver
{

    public function created(HUD $hud)
    {

		$name = $hud->name;
		$id = $hud->id;
		$uniqueCode = generateUniqueCode($name, $id);
		$hud->unique_code = $uniqueCode;
    	$hud->save();

        // $user = new User();
        // $contact = new Contact();
        // $user = $user->createHUDUser($hud);
        // $contact->createNewHUDContact($hud,$user);

    }
}
