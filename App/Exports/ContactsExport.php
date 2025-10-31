<?php

namespace App\Exports;

use App\Models\Contact;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class ContactsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Contact::with(['contactType','designation'])->where('status', _active())->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email Address',
            'Phone Number',
            'Designation',
            'Contact Type',
            'HUD',
            'Block',
            'PHC',
            'HSC',
            
        ];
    }

    /**
    * @var Invoice $invoice
    */
      public function map($contact): array
    {
        return [
            $contact->name,
            $contact->email_id,
            $contact->mobile_number,
            $contact->designation->name ?? '',
            $contact->contactType->name ?? '',
            $contact->hud->name ?? '',
            $contact->block->name ?? '',
            $contact->phc->name ?? '',
            $contact->hsc->name ?? '',
            
        ];
    }
}

   
    

