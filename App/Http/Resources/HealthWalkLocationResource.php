<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HealthWalkLocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $contact = $this->contact_number ?? '';
        
        // Check if "+91" is not present in the string and prepend it
        if ($contact && strpos($contact, '+91') !== 0) {
            $contact = '+91-' . $contact;
        }

        return [
            'district_name' => $this->hud->district->name ?? '--',
            'hud_name' => $this->hud->name ?? '--',
            'area' => $this->area ?? '--',
            'description' => $this->description ?? '--',
            'start_point' => $this->start_point ?? '--',
            'end_point' => $this->end_point ?? '--',
            'contact' => $contact ?? '--',
            'address' => $this->address ?? '--',
            'location_url' => $this->location_url ?? ''
        ];
    }
}
