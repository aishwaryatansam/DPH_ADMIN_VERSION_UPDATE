<?php

namespace App\Exports;

use App\Models\Document;
use App\Models\Tag;
use App\Models\Navigation;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithTitle;




class DocumentsExport implements FromCollection, WithHeadings, WithMapping,WithStyles,WithTitle
{
    private $index = 0;
    private $documents = NULL;
   

    public function collection()
    {
        $this->collectDocuments();
        return Tag::where('status', _active())->get();
    }

    public function collectDocuments() {
        $this->documents = Document::where('status',_active())->get();
    }


    public function headings(): array
    {

        return [
            // ['HUD Status Report Status as on '.date('d-M-Y')],
            [
            'Documents Types / Sections',
            '',
            'Government Order',
            'Circulars',
            'Instructions',
            'Acts/Rules',
            'Proceedings',
            'Publications',
            'Others',
            'News & Notifications',
            'Events',
            'Important Links',
            'RTI',
            'Announcements',
            'Library',
            'Total',

            ]
        ];
    }

    /**
     * @var Invoice $invoice
     */
    public function map($tag): array
    {

      //$tagNames = $document->tags->pluck('name')->implode(', ');
        return [
          $tag->name,
          '',
          (String)$this->getGOCount($tag->id),
          (String)$this->getCircularCount($tag->id),
          (String)$this->getInstructionsCount($tag->id),
          (String)$this->getActsCount($tag->id),
          (String)$this->getProceedingsCount($tag->id),
          (String)$this->getPublicationsCount($tag->id),
          (String)$this->getOthersCount($tag->id),
          (String)$this->getNewsCount($tag->id),
          (String)$this->getEventsCount($tag->id),
          (String)$this->getImportantLinksCount($tag->id),
          (String)$this->getRTICount($tag->id),
          (String)$this->getAnnouncementsCount($tag->id),
          (String)$this->getLibraryCount($tag->id),
          (String)$this->getTotalCount($tag->id),
             

        ];
    }

    public function getGOCount($tag_id) {
         return $this->documents->where('tag_id',$tag_id)
                            ->where('navigation_id','==',1)
                            ->count();
    }

    public function getCircularCount($tag_id) {
         return $this->documents->where('tag_id',$tag_id)
                            ->where('navigation_id','==',2)
                            ->count();
    }

    public function getInstructionsCount($tag_id) {
         return $this->documents->where('tag_id',$tag_id)
                            ->where('navigation_id','==',3)
                            ->count();
    }

    public function getActsCount($tag_id) {
         return $this->documents->where('tag_id',$tag_id)
                            ->where('navigation_id','==',4)
                            ->count();
    }

    public function getProceedingsCount($tag_id) {
         return $this->documents->where('tag_id',$tag_id)
                            ->where('navigation_id','==',5)
                            ->count();
    }

    public function getPublicationsCount($tag_id) {
         return $this->documents->where('tag_id',$tag_id)
                            ->where('navigation_id','==',6)
                            ->count();
    }

    public function getOthersCount($tag_id) {
         return $this->documents->where('tag_id',$tag_id)
                            ->where('navigation_id','==',7)
                            ->count();
    }

    public function getNewsCount($tag_id) {
         return $this->documents->where('tag_id',$tag_id)
                            ->where('navigation_id','==',8)
                            ->count();
    }

    public function getEventsCount($tag_id) {
         return $this->documents->where('tag_id',$tag_id)
                            ->where('navigation_id','==',9)
                            ->count();
    }

    public function getImportantLinksCount($tag_id) {
         return $this->documents->where('tag_id',$tag_id)
                            ->where('navigation_id','==',10)
                            ->count();
    }

    public function getRTICount($tag_id) {
         return $this->documents->where('tag_id',$tag_id)
                            ->where('navigation_id','==',11)
                            ->count();
    }

    public function getAnnouncementsCount($tag_id) {
         return $this->documents->where('tag_id',$tag_id)
                            ->where('navigation_id','==',12)
                            ->count();
    }

    public function getLibraryCount($tag_id) {
         return $this->documents->where('tag_id',$tag_id)
                            ->where('navigation_id','==',13)
                            ->count();
    }

    public function getTotalCount($tag_id) {
         return $this->documents->where('tag_id',$tag_id)
                            ->where('navigation_id','!=',NULL)
                            ->count();
    }



    public function sno() {
        return $this->index = $this->index+1;
    }


    public function headingRow(): int
    {
        return 1;
    }


    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
            // 2    => ['font' => ['bold' => true]],
        ];
    }



    

    public function title(): string
    {
        return 'Document Report';
    }

}
