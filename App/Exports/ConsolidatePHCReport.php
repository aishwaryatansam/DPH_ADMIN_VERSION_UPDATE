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
use App\Models\PHC;

class ConsolidatePHCReport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithBackgroundColor, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $results = collect();
        $chunkSize = 1000;

        PHC::whereHas('block.hud', function ($query) {
                $query->filter();
            })
            ->with([
                'block.hud' => function ($query) {
                    $query->filter();
                },
            ])
            ->withCount('phc_contacts_report')
            ->chunk($chunkSize, function ($phcs) use (&$results) {
                $results = $results->merge($phcs);
            });

        return $results;

    }

    public function title(): string
    {
        return 'PHC';
    }

    public function headings(): array
    {
        return [
            [
                'Name of the HUD',
                'Block',
                'PHC',
                'Image',
                'Map',
                'Video',
                'Land Document',
                'No.of Contacts Updated',
            ]
        ];
    }

    public function map($phc): array
    {
        return [
            $phc->block->hud->name ?? '',
            $phc->block->name ?? '',
            $phc->name ?? '',
            (isset($phc->image_url) && $phc->image_url) ? 'yes' : 'no',
            (isset($phc->location_url) && $phc->location_url) ? 'yes' : 'no',
            (isset($phc->video_url) && $phc->video_url) ? 'yes' : 'no',
            (isset($phc->property_document_url) && $phc->property_document_url) ? 'yes' : 'no',
            (string)($phc->phc_contacts_report_count ?? '0'),
        ];
    }

    public function sno()
    {
        return $this->index = $this->index + 1;
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function backgroundColor()
    {
        // return new Color(Color::COLOR_YELLOW);
    }
}
