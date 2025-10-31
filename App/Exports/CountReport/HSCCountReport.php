<?php

namespace App\Exports\CountReport;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Collection;

class HSCCountReport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithBackgroundColor, WithTitle
{
    private $index = 0;
    private $huds;
    private $blocks;
    private $phcs;
    private $hscs;
    private $contacts;

    public function __construct($huds, $blocks, $phcs, $hscs, $contacts)
    {
        $this->huds = $huds;
        $this->blocks = $blocks;
        $this->phcs = $phcs;
        $this->hscs = $hscs;
        $this->contacts = $contacts;
    }

    public function collection()
    {
        return $this->hscs;
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
            'No.of Contacts Updated',
        ];
    }

    public function map($hsc): array
    {
        $phc = $this->phcs->find(optional($hsc)->phc_id);
        $block = $this->blocks->find(optional($phc)->block_id);
        $hud = $this->huds->find(optional($block)->hud_id);
        $contacts = $this->contacts
            ->where('hud_id', optional($block)->hud_id)
            ->where('block_id', optional($block)->id)
            ->where('phc_id', optional($phc)->id);

        return [
            optional($hud)->name ?? '',
            optional($block)->name ?? '',
            optional($phc)->name ?? '',
            optional($hsc)->name ?? '',
            (isset($hsc->image_url) && $hsc->image_url) ? 'yes' : 'no',
            (isset($hsc->location_url) && $hsc->location_url) ? 'yes' : 'no',
            (isset($hsc->video_url) && $hsc->video_url) ? 'yes' : 'no',
            (string)$contacts->where('hsc_id', optional($hsc)->id)->count(),
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
