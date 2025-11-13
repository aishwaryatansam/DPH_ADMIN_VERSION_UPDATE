<?php

namespace App\Exports;

use App\Models\Section;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SectionExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return ['Serial No', 'Program Name', 'Section Name', 'Short Code', 'Status'];
    }

    public function array(): array
    {
        $sections = DB::table('sections')
            ->join('programs', 'sections.programs_id', '=', 'programs.id')
            ->select(
                'programs.name as program_name',
                'sections.name as section_name',
                'sections.short_code',
                DB::raw("CASE WHEN sections.status = 1 THEN 'Active' ELSE 'Inactive' END as status")
            )
            ->orderBy('sections.id', 'asc')
            ->get();

        $formatted = $sections->map(function ($section, $index) {
            return [
                'Serial No'    => $index + 1,
                'Program Name' => $section->program_name,
                'Section Name' => $section->section_name,
                'Short Code'   => $section->short_code ?? '-',
                'Status'       => $section->status,
            ];
        });

        return $formatted->toArray();
    }
}
