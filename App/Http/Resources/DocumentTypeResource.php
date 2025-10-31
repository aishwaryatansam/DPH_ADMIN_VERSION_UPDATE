<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class DocumentTypeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->slug_key, // Assuming you have a slug field or similar identifier
            'title' => $this->name, // The title of the document type
            'image' => $this->icon_url ? fileLink($this->icon_url) : 'assets/Icons_image/vaccination.png', // Replace with the default image or provide actual image link
        ];
    }
}
