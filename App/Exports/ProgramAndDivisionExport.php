<?php

namespace App\Exports;

use App\Models\Program;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProgramAndDivisionExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return ['Serial No', 'Program Name', 'Division', 'Short Code', 'Order No', 'Status'];
    }

    public function array(): array
    {
        // Adjust the join and table names as per your actual schema
        $programs = Program::leftJoin('divisions', 'programs.id', '=', 'divisions.id')
            ->select(
                'programs.id as serial_no',
                'programs.name as program_name',
                'divisions.name as division_name',
                'programs.short_code',
                'programs.order_no',
                DB::raw("CASE WHEN programs.status = 1 THEN 'Active' ELSE 'Inactive' END AS status")
            )
            ->orderBy('programs.order_no', 'asc')
            ->get();

        return $programs->toArray();
    }
}
