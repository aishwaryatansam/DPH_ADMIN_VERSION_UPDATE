<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DivisionResource;
use Illuminate\Support\Facades\Validator;
use App\Models\Division;

class DivisionController extends Controller
{

    /**
     * Method to retrieve the divisions for homepage section
     * 
     * @param Request
     * @return DivisionResource as Json
     * 
     * */
    public function getDivisions(Request $request) {
        
        $validator = Validator::make($request->all(),[
            'parent_division_id' => 'sometimes|exists:divisions,id,status,'._active(),
        ]);

        if ($validator->fails()) {
            return sendError($validator->errors());
        }

        $divisions = Division::getDivisionData($request->parent_division_id);
        return sendResponse(DivisionResource::collection($divisions));
    }
}
