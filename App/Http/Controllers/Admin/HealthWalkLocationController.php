<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HealthWalkLocation;
use App\Models\District;
use App\Http\Resources\HealthWalkLocationResource;

class HealthWalkLocationController extends Controller
{
    public function index() {
        $locationData = HealthWalkLocation::getLocationData();
        return view('admin.health-walk.create',compact('locationData'));
    }

    public function store(Request $request) {
        $districts = District::get();
        $locationPostData = $request->all();
        $contact_numbers = $locationPostData['contact_number'] ?? [];
        $location_urls = $locationPostData['location_url'] ?? [];
        $addresses = $locationPostData['address'] ?? [];

        $updateArray = [];
        foreach($districts as $district) {
            // Check if the variables exist and are not null
            if (
                array_key_exists($district->id, $contact_numbers) &&
                array_key_exists($district->id, $location_urls) &&
                array_key_exists($district->id, $addresses)
            ) {
                
                HealthWalkLocation::updateOrCreate(
                    ['district_id' => $district->id],
                    [
                        'contact_number' => $contact_numbers[$district->id],
                        'address' => $addresses[$district->id],
                        'location_url' => $location_urls[$district->id],
                    ]
                );
                
            }
        }
        updatedResponse("Health Walk Details Updated Successfully");

        return redirect('/hw-location');
    }

     public function getHealthWalkLocations(Request $request) {

        $locationDatas = HealthWalkLocation::getLocationData();
        return sendResponse(HealthWalkLocationResource::collection($locationDatas));
    }

}
