<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WebsiteDocumentResource extends JsonResource
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
            'document_id' => $this->id,
            'document_type_id' => $this->document_type_id ,
            'section_id' => $this->section_id ?? '',
            'document_name' => $this->name,
            'description' => $this->description,
            'link' => $this->link,
            'publication_type_id ' => $this->publication_type_id ,
            'notification_type_id ' => $this->notification_type_id ,
            'expiry_date' => $this->expiry_date,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'image_url' => fileLink($this->image_url),
            'financial_year' => $this->financial_year,
            'language_id ' => $this->language_id,
            'link_title' => $this->link_title,
            'user_id ' => $this->user_id,
            'document_url' => fileLink($this->document_url),
            'visible_to_public' => ($this->visible_to_public == _active()),
            'reference_no' => $this->reference_no,
            'dated' => $this->dated,
        ];
        // return parent::toArray($request);
    }
}
