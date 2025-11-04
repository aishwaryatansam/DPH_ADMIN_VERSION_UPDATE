<?php

namespace App\Exports;

use App\Models\HSC;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HSCExport implements FromCollection, WithHeadings
{
    protected $phcId;

    public function __construct($phcId = null)
    {
        $this->phcId = $phcId;
    }

    public function collection()
    {
        $query = HSC::with('phc:id,name')
            ->select('id', 'name', 'phc_id', 'status');

        if ($this->phcId) {
            $query->where('phc_id', $this->phcId);
        }

        return $query->get()->map(function ($hsc) {
            return [
                'ID' => $hsc->id,
                'Name' => $hsc->name,
                'PHC Name' => optional($hsc->phc)->name ?? 'N/A',
                'Status' => $hsc->status ? 'Active' : 'Inactive',
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'PHC Name', 'Status'];
    }
}
