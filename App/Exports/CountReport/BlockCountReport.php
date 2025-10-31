<?php

namespace App\Exports\CountReport;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Collection;

class BlockCountReport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithBackgroundColor, WithTitle
{
    private $index = 0;
    private $huds;
    private $blocks;
    private $contacts;

    public function __construct($huds, $blocks, $contacts)
    {
        $this->huds = $huds;
        $this->blocks = $blocks;
        $this->contacts = $contacts;
    }

    public function collection()
    {
        return $this->blocks;
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
                'No.of Contacts Updated',
            ]
        ];
    }

    public function map($block): array
    {
        $hud = $this->huds->where('id', $block->hud_id)->first();
        $contacts = $this->contacts->where('hud_id', $block->hud_id)->where('block_id', $block->id);

        return [
            $hud->name ?? '',
            $block->name ?? '',
            (isset($block->image_url) && $block->image_url) ? 'yes' : 'no',
            (isset($block->location_url) && $block->location_url) ? 'yes' : 'no',
            (isset($block->video_url) && $block->video_url) ? 'yes' : 'no',
            (string)$contacts->count(),
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
