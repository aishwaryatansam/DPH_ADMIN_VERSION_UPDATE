<?php

namespace App\Exports;

use App\Models\Program;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProgramDetailsExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return ['Serial No', 'Program Name', 'Status'];
    }

    public function array(): array
    {
        $programs = Program::leftJoin('programdetail', 'programs.id', '=', 'programdetail.programs_id')
        ->select('programs.id', 'programs.name', DB::raw("CASE 
            WHEN MIN(programdetail.id) IS NULL THEN 'No'
            WHEN MIN(programdetail.status) = 1 THEN 'Yes'
            ELSE 'Yes - Inactive' END AS status"))
        ->groupBy('programs.id', 'programs.name')
        ->get();
    


        return $programs->toArray();
    }
}