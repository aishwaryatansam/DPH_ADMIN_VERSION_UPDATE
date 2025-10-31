<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HUDResource extends JsonResource
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
            'id' => $this->hud_id,
            'name' => $this->facility_name,
            'district_id' => $this->district_id,
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

            // 'contact' => [
            //     'contact_id' => $this->hud_contact->id ?? '',
            //     'is_post_vacant' => $this->hud_contact->is_post_vacant ?? '',
            //     'name' => $this->hud_contact->name ?? '',
            //     'phone_number' => $this->hud_contact->mobile_number ?? '',
            //     'email_address' => $this->hud_contact->email_id ?? '',
            //     'landline_number' => $this->hud_contact->landline_number ?? '',
            //     'designation' => $this->hud_contact->designation->name ?? '',
            //     'fax' => $this->hud_contact->fax ?? '',
            //     'image_url' => '',
            //     'location_url' => '',
            // ],
        ];
    }
}
