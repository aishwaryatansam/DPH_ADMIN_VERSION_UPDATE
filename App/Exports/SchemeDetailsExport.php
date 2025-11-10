<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SchemeDetailsExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return ['Serial No', 'Program Name', 'Scheme Name', 'Short Code', 'Status'];
    }

    public function array(): array
    {
        $schemes = DB::table('schemes')
            ->join('programs', 'schemes.programs_id', '=', 'programs.id')
            ->leftJoin('scheme_details', 'schemes.id', '=', 'scheme_details.schemes_id')
            ->leftJoin('programdetail', 'programs.id', '=', 'programdetail.programs_id')
            ->select(
                'programs.name as program_name',
                'schemes.name as scheme_name',
                'schemes.short_code', // ✅ Added this line
                DB::raw("CASE 
                    WHEN MIN(scheme_details.id) IS NULL THEN 'No'
                    WHEN MIN(scheme_details.status) = 1 THEN 'Yes'
                    ELSE 'Yes - Inactive' 
                END AS status")
            )
            ->groupBy('programs.id', 'programs.name', 'schemes.id', 'schemes.name', 'schemes.short_code') // ✅ Added short_code here too
            ->get();

        $formattedData = $schemes->map(function ($scheme, $index) {
            return [
                'Serial No' => $index + 1,
                'Program Name' => $scheme->program_name,
                'Scheme Name' => $scheme->scheme_name,
                'Short Code' => $scheme->short_code ?? '-', // ✅ Safe default
                'Status' => $scheme->status,
            ];
        });

        return $formattedData->toArray();
    }
}
