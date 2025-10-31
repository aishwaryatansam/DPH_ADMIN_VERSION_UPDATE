<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RtiOfficerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'title' => $this->title,
            'designation' => $this->designation->name ?? '',
            'mobile_number' => $this->mobile_number,
            'email' => $this->email,
            'landline_number' => $this->landline_number,
            'extn' => $this->extn,
            'fax' => $this->fax,
            'address' => $this->address,
            
        ];
    }
}
