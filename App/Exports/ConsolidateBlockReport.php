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
use App\Models\Block;

class ConsolidateBlockReport implements FromCollection, WithHeadings, WithMapping,WithStyles,WithBackgroundColor,WithTitle
{
    private $index = 0;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Block::filter()->with('hud:id,name')->withCount('block_contacts_report')->get();
    }

    public function title(): string
    {
        return 'Block';
    }

    public function headings(): array
    {
        return [
            [
                'Name of the HUD',
                'Block',
                'Image',
                'Map',
                'Video',
                'Land Document',
                'No.of Contacts Updated',
            ]
        ];
    }

    public function map($block): array
    {

        return [
            $block->hud->name ?? '',
            $block->name ?? '',
            (isset($block->image_url) && $block->image_url) ? 'yes' : 'no',
            (isset($block->location_url) && $block->location_url) ? 'yes' : 'no',
            (isset($block->video_url) && $block->video_url) ? 'yes' : 'no',
            (isset($block->property_document_url) && $block->property_document_url) ? 'yes' : 'no',
            (string)($block->block_contacts_report_count ?? '0'),
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
