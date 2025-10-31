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
            'document_type_id' => $this->document_type_id,
            'section_id' => $this->section_id ?? '',
            'title' => $this->name,
            'description' => $this->description,
            'link' => $this->link,
            'publication_type_id' => $this->publication_type_id,
            'publication_type' => $this->publication->name ?? '',
            'notification_type_id' => $this->notification_type_id,
            'notification_type' => $this->notification->name ?? '',
            'event_type_id' => $this->event_type_id,
            'event_type' => $this->event->name ?? '',
            'expiry_date' => $this->expiry_date,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'image_url' => fileLink($this->image_url),
            'financial_year' => $this->financial_year,
            'language_id ' => $this->language_id,
            'language' => $this->language->name ?? '',
            'link_title' => $this->link_title,
            'user_id ' => $this->user_id,
            'user' => $this->user->name,
            'document_url' => fileLink($this->document_url),
            'visible_to_public' => ($this->visible_to_public == _active()),
            'reference_no' => $this->reference_no,
            'dated' => $this->dated,
            'fileSize' => $this->getFileSize(),
            'program_id' => $this->scheme->programs_id ?? '',
            'scheme_id' => $this->scheme_id ?? '',
            'iconimage' => 'assets/Icons_image/pdf.png',
            'upload_events' => $this->upload_events->map(function ($uploadEvent) {
                return [
                    'id' => $uploadEvent->id,
                    'event_id' => $uploadEvent->event_id ?? '',
                    'user_id' => $uploadEvent->user_id ?? '',
                    'video_url' => $uploadEvent->video_url ?? '',
                    'document_url' => fileLink($uploadEvent->document_url) ?? '',
                    'uploader_name' => $uploadEvent->user->name ?? '',
                    'uploader_facility_name' => $uploadEvent->user->facility_hierarchy->facility_name ?? '',
                    'uploader_facility_level' => findFacilityLevel($uploadEvent->user->facility_hierarchy->facility_level_id ?? '') ?? '',
                    'created_at' => createdAt($uploadEvent->created_at) ?? '',
                    'event_images' => $uploadEvent->event_images->map(function ($eventImage) {
                        return [
                            'id' => $eventImage->id,
                            'image_url' => fileLink($eventImage->image_url ?? ''),
                        ];
                    }),
                ];
            }),
        ];
    }

    private function getFileSize()
    {
        $url = fileLink($this->document_url); // Get the full URL
        // Check if the URL is local
        if (strpos($url, request()->getHost()) !== false) { // Check if it's a local URL
            // Construct the local file path
            // $filePath = public_path(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, parse_url($url, PHP_URL_PATH)));
            $fixed_url = str_replace('/admin/', '/', $url);
            $filePath = public_path(parse_url($fixed_url, PHP_URL_PATH));
            return file_exists($filePath) ? humanFileSize(filesize($filePath)) : 'N/A';
        }
    }
}
