<?php

namespace App\Exports;

use App\Models\HUD;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithTitle;


class HUDReport implements FromCollection, WithHeadings, WithMapping,WithStyles,WithBackgroundColor,WithTitle
{
    private $index = 0;

    public function collection()
    {
        return HUD::collectHudData();
    }

    public function headings(): array
    {

        return [
            // ['HUD Status Report Status as on '.date('d-M-Y')],
            ['SI.No',
            'Name of the HUD',
            'Profile Updated',
            'Photo Upload',
            'Contact',
            'Map Location',
            'Video Upload',]
        ];
    }

    /**
     * @var Invoice $invoice
     */
    public function map($hud): array
    {
        return [
            $this->sno(),
            $hud->name,
            ($hud->designation_id) ? 'Yes':'No',
            (isset($hud->image_url) && $hud->image_url)?fileLink($hud->image_url): '',
            $hud->hud_contact->name ?? '',
            $hud->location_url ?? '',
            $hud->video_url ?? '',
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
        return new Color(Color::COLOR_YELLOW);

    }

    public function title(): string
    {
        return 'HUD Report';
    }
}
