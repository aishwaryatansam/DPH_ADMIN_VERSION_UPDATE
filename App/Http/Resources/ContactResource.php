<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'is_post_vacant' => $this->is_post_vacant,
            'designation' => $this->designation->name ?? '',
            'email_address' => $this->email_id,
            'landline_number' => $this->landline_number,
            'image_url' => (isset($this->image_url) && $this->image_url)?fileLink($this->image_url): '',
            'location_url' => $this->location_url,
            'phone_number' => $this->mobile_number,
            'fax' => $this->fax,
            'contact_type' => $this->contact_type,

            'facility_name' => $this->facility->facility_name ?? '',
            'facility_code' => $this->facility->facility_code ?? '',
            'facility_type' => $this->facility->facility_type_id ?? '',
            'hud_id' => $this->facility->hud_id ?? null,
            'block_id' => $this->facility->block_id ?? null,
            'phc_id' => $this->facility->phc_id ?? null,
            'hsc_id' => $this->facility->hsc_id ?? null,
            
            'is_urban' => $this->facility && $this->facility->area_type !== null 
                      ? $this->facility->area_type == 1 
                      : false,
        ];
    }
}
