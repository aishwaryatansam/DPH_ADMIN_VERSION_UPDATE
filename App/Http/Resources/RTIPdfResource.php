<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RTIPdfResource extends JsonResource
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
            'file_name' => $this->file_name,
            'file_path' => $this->fileUrl,
            'upload_date' => $this->upload_date,
        ];
    }
}
