<?php

namespace App\Exports;

use App\Models\PHC;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PHCExport implements FromCollection, WithHeadings
{
    protected $blockId;

    public function __construct($blockId = null)
    {
        $this->blockId = $blockId;
    }

    public function collection()
    {
        $query = PHC::with('block');

        if ($this->blockId) {
            $query->where('block_id', $this->blockId);
        }

        return $query->get()->map(function ($phc) {
            return [
                'PHC Name'   => $phc->name ?? '',
                'Block Name' => $phc->block->name ?? '',
                'Status'     => $phc->status == 1 ? 'Active' : 'In-Active',
            ];
        });
    }

    public function headings(): array
    {
        return ['PHC Name', 'Block Name', 'Status'];
    }
}
