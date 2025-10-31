<?php

namespace App\Exports;

use App\Models\User;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CustomersExport implements FromCollection, WithHeadings, WithMapping
{    

    public function collection()
    {
        return User::where('user_type_id',_employeeUserTypeId())->get();
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Email Address',
            'Contact Number',
            'Section',
            'Designation',
            'Status',
            'Created At'
        ];
    }

    /**
    * @var Invoice $invoice
    */
    public function map($employee): array
    {
        return [
            $employee->name,
            $employee->email,
            $employee->contact_number,
            $employee->section,
            $employee->designation,
            findStatus($employee->status),
            dateOf($employee->created_at),
        ];
    }
}
