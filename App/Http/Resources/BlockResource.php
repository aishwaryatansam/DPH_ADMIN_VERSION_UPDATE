<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $other_contacts = [];

        if(!empty($this->block_contacts))
        {
            foreach($this->block_contacts as $block_contacts) {
                $other_contacts[] = [
                    'contact_id' => $block_contacts->id ?? '',
                    'is_post_vacant' => $block_contacts->is_post_vacant ?? '',
                    'name' => $block_contacts->name ?? '',
                    'phone_number' => $block_contacts->mobile_number ?? '',
                    'email_address' => $block_contacts->email_id ?? '',
                    'landline_number' => $block_contacts->landline_number ?? '',
                    'designation' => $block_contacts->designation->name ?? '',
                    'fax' => $block_contacts->fax ?? '',
                    'image_url' => '',
                    'location_url' => '',
                ];
            }
        }
        return [
            'id' => $this->id,
            'name' => $this->facility_name,
            'hud_id' => $this->hud_id,
            'block_id' => $this->block_id,
            'facility_level' => $this->facility_level->name,
            // 'image_url' => (isset($this->image_url) && $this->image_url)?fileLink($this->image_url): '',
            // 'land_document_url' => (isset($this->property_document_url) && $this->property_document_url)?fileLink($this->property_document_url): '',

            'image_url' => $this->facilityProfile->images->map(function ($image) {
                return [
                    'url' => fileLink($image->image_url),
                    'description' => $image->description,
                    'type' => $image->image_type,
                ];
            }),

            'land_document_url' => $this->facilityProfile->documents->map(function ($doc) {
                return [
                    'url' => fileLink($doc->document_url),
                    'type' => $doc->document_type,
                ];
            }),
            "video_url" => $this->facilityProfile->video_url ?? '',
            "location_url" => $this->facilityProfile->location_url ?? '',
            'phone_number' => $this->facilityProfile->mobile_number ?? '',
            'email_address' => $this->facilityProfile->email_id ?? '',
            'landline_number' => $this->facilityProfile->landline_number ?? '',
            'abdm_facility_number' => $this->facilityProfile->abdm_facility_number ?? '',
            'nin_number' => $this->facilityProfile->nin_number ?? '',
            'picme' => $this->facilityProfile->picme ?? '',
            'hmis' => $this->facilityProfile->hmis ?? '',
            'address' => trim(($this->facilityProfile->address_line1 ?? '') . ', ' . ($this->facilityProfile->address_line2 ?? ''), ', '),
            'pincode' => $this->facilityProfile->pincode ?? '',
        ];
    }
}
