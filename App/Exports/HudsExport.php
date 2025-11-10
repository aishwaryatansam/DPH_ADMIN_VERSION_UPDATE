<?php

namespace App\Exports;

use App\Models\HUD;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HudsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return HUD::with('district')
            ->get()
            ->map(function($hud) {
                return [
                    'HUD Name' => $hud->name,
                    'District Name' => $hud->district->name ?? '',
                    'Status' => $hud->status ? 'Active' : 'In-Active'
                ];
            });
    }

    public function headings(): array
    {
        return ['HUD Name', 'District Name', 'Status'];
    }
}
