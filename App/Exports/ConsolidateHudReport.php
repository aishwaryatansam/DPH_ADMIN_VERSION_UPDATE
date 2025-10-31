<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\HUD;

class ConsolidateHudReport implements FromCollection, WithHeadings, WithMapping,WithStyles,WithBackgroundColor,WithTitle
{
    private $index = 0;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return HUD::filter()->withCount('hud_contacts')->get();
    }

    public function title(): string
    {
        return 'HUD';
    }

    public function headings(): array
    {

        return [            
            [
                'Name of the HUD', 
                'Image', 
                'Map', 
                'Video', 
                'Land Document',
                'No.of Contacts Updated',
            ]
        ];
    }

    public function map($hud): array
    {
        return [
            $hud->name,
            (isset($hud->image_url) && $hud->image_url)?'yes': 'no',
            (isset($hud->location_url) && $hud->location_url)?'yes':'no',
            (isset($hud->video_url) && $hud->video_url)?'yes':'no',
            (isset($hud->property_document_url) && $hud->property_document_url)?'yes':'no',
            (String)($hud->hud_contacts_count ?? '0'),
        ];
    }


    public function sno() {
        return $this->index = $this->index+1;
    }

    public function headingRow(): int
    {
        return 1;
    }


    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
            // 2    => ['font' => ['bold' => true]],
        ];
    }



    public function backgroundColor()
    {
        // Return a Color instance. The fill type will automatically be set to "solid"
        // return new Color(Color::COLOR_YELLOW);

    }
}
