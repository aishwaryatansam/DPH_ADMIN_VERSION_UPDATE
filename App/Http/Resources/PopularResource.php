<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PopularResource extends JsonResource
{
    public function toArray($request)
    {
        // Customize fields as needed
        return [
            'id' => $this->id,
            'name' => $this->name,
            'descript' => $this->descript,
            'img' => $this->img,
            'status' => $this->status,
            'tags' => $this->tags,
            'tag_names' => $this->tag_names ?? '',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
