<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
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
        "id" => $this->id,
        "name" => $this->name,
        "designation" => $this->designation,
        "image_url" =>  (isset($this->image_url) && $this->image_url)?fileLink($this->image_url): '',
        "testimonial_document_url" =>  (isset($this->testimonial_document_url) && $this->testimonial_document_url)?fileLink($this->testimonial_document_url): '',
        "content" => $this->content,
        "unique_key" => $this->unique_key,
        "role" => findTestimonialRole($this->role),    
        ];
    }
}