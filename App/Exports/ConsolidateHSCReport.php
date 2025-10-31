<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\HSC;

class ConsolidateHSCReport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithBackgroundColor, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $results = collect();
        $chunkSize = 1000;

        HSC::whereHas('phc.block.hud', function ($query) {
                $query->filter();
            })
            ->with([
                'phc.block.hud' => function ($query) {
                    $query->filter();
                },
            ])
            ->withCount('hsc_contacts')
            ->chunk($chunkSize, function ($hscs) use (&$results) {
                $results = $results->merge($hscs);
            });

        return $results;

    }

    public function title(): string
    {
        return 'HSC';
    }

    public function headings(): array
    {
        return [
            'Name of the HUD',
            'Block',
            'PHC',
            'HSC',
            'Image',
            'Map',
            'Video',
            'Land Document',
            'No.of Contacts Updated',
        ];
    }

    public function map($hsc): array
    {
        return [
            optional($hsc->phc->block->hud)->name ?? '',
            optional($hsc->phc->block)->name ?? '',
            optional($hsc->phc)->name ?? '',
            optional($hsc)->name ?? '',
            (isset($hsc->image_url) && $hsc->image_url) ? 'yes' : 'no',
            (isset($hsc->location_url) && $hsc->location_url) ? 'yes' : 'no',
            (isset($hsc->video_url) && $hsc->video_url) ? 'yes' : 'no',
            (isset($hsc->property_document_url) && $hsc->property_document_url) ? 'yes' : 'no',
            (string)($hsc->hsc_contacts_count ?? '0'),
        ];
    }

    public function sno()
    {
        return ++$this->index;
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
