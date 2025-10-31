<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DivisionResource extends JsonResource
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
            'division_icon' => (isset($this->division_icon) && $this->division_icon)?fileLink($this->division_icon): '',
            'division_head_name_one' => $this->division_head_name_one ?? '',
            'division_head_name_two' => $this->division_head_name_two ?? '',
            'division_head_name_three' => $this->division_head_name_three ?? '',
            'division_head_image_one' => (isset($this->division_head_image_one) && $this->division_head_image_one)?fileLink($this->division_head_image_one): '',
            'division_head_image_two' => (isset($this->division_head_image_two) && $this->division_head_image_two)?fileLink($this->division_head_image_two): '',
            'division_head_image_three' => (isset($this->division_head_image_three) && $this->division_head_image_three)?fileLink($this->division_head_image_three): '',
            'division_head_status_one' => $this->division_head_status_one,
            'division_head_status_two' => $this->division_head_status_two,
            'division_head_status_three' => $this->division_head_status_three,
        ];
    }
}
