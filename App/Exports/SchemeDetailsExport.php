<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SchemeDetailsExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return ['Serial No', 'Program Name', 'Scheme Name', 'Status'];
    }

    public function array(): array
    {
        $schemes = DB::table('schemes')
            ->join('programs', 'schemes.programs_id', '=', 'programs.id') // Joining schemes with programs
            ->leftJoin('scheme_details', 'schemes.id', '=', 'scheme_details.schemes_id') // Linking scheme details
            ->leftJoin('programdetail', 'programs.id', '=', 'programdetail.programs_id') // Linking program details for status
            ->select(
                'programs.name as program_name',
                'schemes.name as scheme_name',
                DB::raw("CASE 
                    WHEN MIN(scheme_details.id) IS NULL THEN 'No'
                    WHEN MIN(scheme_details.status) = 1 THEN 'Yes'
                    ELSE 'Yes - Inactive' 
                END AS status")
            )
            ->groupBy('programs.id', 'programs.name', 'schemes.id', 'schemes.name') // Grouping by program & scheme
            ->get();

        // Formatting output with Serial Number
        $formattedData = $schemes->map(function ($scheme, $index) {
            return [
                'Serial No' => $index + 1, 
                'Program Name' => $scheme->program_name, 
                'Scheme Name' => $scheme->scheme_name,
                'Status' => $scheme->status,
            ];
        });

        return $formattedData->toArray();
    }
}
