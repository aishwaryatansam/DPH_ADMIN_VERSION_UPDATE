<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SchemeExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($item) {
            return [
                'ID' => $item->id,
                'Program' => $item->scheme->program->name ?? '',
                'Scheme' => $item->scheme->name ?? '',
               
                'Status' => $item->status == 1 ? 'Active' : 'Inactive',
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'Program', 'Scheme', 'Status'];
    }
}
