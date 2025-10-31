<?php

namespace App\Http\Resources;

use App\Models\EventUpload;
use App\Models\MediaGallery;
use App\Models\ProgramDetail;
use App\Models\SchemeDetail;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaGalleryResource extends JsonResource
{
    public function toArray($request)
    {
        // Check which model the resource belongs to
        if ($this->resource instanceof EventUpload) {
            return $this->eventUploadData();
        } elseif ($this->resource instanceof ProgramDetail) {
            return $this->programDetailData();
        } elseif ($this->resource instanceof SchemeDetail) {
            return $this->schemeDetailData();
        } elseif ($this->resource instanceof MediaGallery) {
            return $this->mediaGalleryData();
        }

        return [];
    }

    // EventUpload data transformation
    private function eventUploadData()
    {
        return [
            'id' => $this->id,
            'event_id' => $this->event_id,
            'event_name' => $this->event->name ?? '',
            'uploaded_by' => $this->user->name ?? '',
            'upload_date' => createdAt($this->created_at),

            // Optional images array if there are related event images
            'images' => $this->event_images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'image_url' => $image->image_url ? fileLink($image->image_url) : '',
                ];
            }),
        ];
    }

     // ProgramDetail data transformation
     private function mediaGalleryData()
     {
         return [
             'id' => $this->id,
             'media_gallery' => config('constant.media_gallery.' . $this->media_gallery),
             'title' => $this->title ?? '',
             'description' => $this->description ?? '',
             'date' => createdAt($this->date),
             'images' => fileLink($this->image),
             'url' => $this->url,
         ];
     }

    // ProgramDetail data transformation
    private function programDetailData()
    {
        return [
            'id' => $this->id,
            'program_id' => $this->program_id,
            'program_name' => $this->program->name ?? '',
            'uploaded_by' => $this->user->name ?? '',
            'upload_date' => createdAt($this->created_at),
            'images' => $this->getProgramImages(),
        ];
    }

    // SchemeDetail data transformation
    private function schemeDetailData()
    {
        return [
            'id' => $this->id,
            'scheme_id' => $this->schemes_id,
            'scheme_name' => $this->scheme->name ?? '',
            'uploaded_by' => $this->user->name ?? '',
            'upload_date' => createdAt($this->created_at),
            'images' => $this->getSchemeImages(),
        ];
    }

    // Helper to get images for ProgramDetail
    private function getProgramImages()
    {
        return collect([
            'image_one', 'image_two', 'image_three', 'image_four', 'image_five'
        ])->map(function ($imageField) {
            return [
                'image_url' => $this->$imageField ? fileLink($this->$imageField) : null
            ];
        })->filter(function ($image) {
            return $image['image_url'] !== null;  // Remove null images
        });
    }

    // Helper to get images for SchemeDetail
    private function getSchemeImages()
    {
        return collect([
            'image_one', 'image_two', 'image_three', 'image_four', 'image_five',
            'report_image_one', 'report_image_two', 'report_image_three', 'report_image_four', 'report_image_five'
        ])->map(function ($imageField) {
            return [
                'image_url' => $this->$imageField ? fileLink($this->$imageField) : null
            ];
        })->filter(function ($image) {
            return $image['image_url'] !== null;  // Remove null images
        });
    }
}

