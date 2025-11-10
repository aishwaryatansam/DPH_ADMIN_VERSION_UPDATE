<?php

namespace App\Exports;

use App\Models\Block;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BlockExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Block::with('hud')->orderBy('name')->get();
    }

    public function map($block): array
    {
        return [
            $block->name ?? '',
            $block->hud->name ?? '',
            $block->status == 1 ? 'Active' : 'In-Active',
        ];
    }

    public function headings(): array
    {
        return ['Block Name', 'HUD', 'Status'];
    }
}
