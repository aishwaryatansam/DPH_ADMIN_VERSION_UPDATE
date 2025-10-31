<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AntiCurruptionResource extends JsonResource
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
            'tamildescription' => $this->tamildescription,
            'englishdescription' => $this->englishdescription,
            'tamiladdress' => $this->tamiladdress,
            'englishaddress' => $this->englishaddress,
            "phone_number" => $this->phone_number ?? '',
            'fax_number' => $this->fax_number ?? '',
            'website ' => $this->website ?? ''
        ];
    }
}
