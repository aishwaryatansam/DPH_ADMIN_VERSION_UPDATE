<?php

namespace App\Exports;

use App\Models\District;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DistrictExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return District::select('id', 'name', 'status')->get()
            ->map(function ($district) {
                $district->status = $district->status ? 'Active' : 'Inactive';
                return $district;
            });
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Status'];
    }
}
