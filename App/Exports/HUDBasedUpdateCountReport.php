<?php

namespace App\Exports;

use App\Models\Contact;
use App\Models\HUD;
use App\Models\Block;
use App\Models\PHC;
use App\Models\HSC;
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
use Illuminate\Support\Str;



class HUDBasedUpdateCountReport implements FromCollection, WithHeadings, WithMapping,WithStyles,WithBackgroundColor,WithTitle
{
    private $index = 0;
    private $contacts = NULL;
    private $huds = NULL;
    private $blocks = NULL;
    private $phcs = NULL;
    private $hscs = NULL;

    public function collection()
    {
        $this->collectContacts();
        $this->collectHuds();
        $this->collectBlocks();
        $this->collectPhcs();
        $this->collectHscs();
        return HUD::where('status',_active())->orderBy('name')->get();
    }

    public function collectContacts() {
        $this->contacts = Contact::whereNull('user_id')->whereNotNull('hud_id')->where('status',_active())->get();
    }

    public function collectHuds() {
        $this->huds = HUD::where('status',_active())->get();
    }

    public function collectBlocks() {
        $this->blocks = Block::where('status',_active())->get();
    }

    public function collectPhcs() {
        $this->phcs = PHC::where('status',_active())->get();
    }

    public function collectHscs() {
        $this->hscs = HSC::where('status',_active())->get();
    }



    public function headings(): array
    {

        return [
            // ['HUD Status Report Status as on '.date('d-M-Y')],
            ['SI.No',
            'Name of the HUD',
            '',
            //'Total No. of HUDs', 
            'HUD Image Upload', 
            'No. of Contacts',
            'HUD Map Location',
            'HUD Video Upload',
            'HUD Land Document',
            '',
            'Total No. of Blocks', 
            'Image Upload', 
            'Contact',
            'Map Location',
            'Video Upload',
            'Block Land Document',
            '',
            'Total No. of PHCs',
            'Image Upload',
            'Contact',
            'Map Location',
            'Video Upload',
            'PHC Land Document',
            '',
            'Total No. of HSCs',
            'Image Upload',
            'Contact',
        	'Map Location',
            'Video Upload',
            'HSC Land Document'
            ]
        ];
    }

    /**
     * @var Invoice $invoice
     */
    public function map($hud): array
    {
        return [
            $this->sno(),
            $hud->name,
            '',
            //(String)$this->getHUDCount($hud->id),
            (String)$this->getHUDImageUpdatedCount($hud->id),
            (String)$this->getHUDContactCount($hud->id),
            (String)$this->getHUDLocationUpdatedCount($hud->id),
            (String)$this->getHUDVideoUpdatedCount($hud->id),
            (String)$this->getHUDLandDocumentCount($hud->id),
            '',
            (String)$this->getBlockCount($hud->id),
            (String)$this->getBlockImageUpdatedCount($hud->id),
            (String)$this->getBlockContactCount($hud->id),
            (String)$this->getBlockLocationUpdatedCount($hud->id),
            (String)$this->getBlockVideoUpdatedCount($hud->id),
            (String)$this->getBlockLandDocumentCount($hud->id),
            '',
            (String)$this->getPHCCount($hud->id),
            (String)$this->getPHCImageUpdatedCount($hud->id),
            (String)$this->getPHCContactCount($hud->id),
            (String)$this->getPHCLocationUpdatedCount($hud->id),
            (String)$this->getPHCVideoUpdatedCount($hud->id),
            (String)$this->getPHCLandDocumentCount($hud->id),
            '',
            (String)$this->getHSCCount($hud->id),
            (String)$this->getHSCImageUpdatedCount($hud->id),
            (String)$this->getHSCContactCount($hud->id),
            (String)$this->getHSCLocationUpdatedCount($hud->id),
            (String)$this->getHSCVideoUpdatedCount($hud->id),
            (String)$this->getHSCLandDocumentCount($hud->id),

        ];
    }

    public function getHUDContactCount($hud_id) {
        return $this->contacts->where('hud_id',$hud_id)
                               ->where('block_id',NULL)
                               ->where('user_id',NULL)
                               ->where('phc_id',NULL)
                               ->where('hsc_id',NULL)
                               ->where('contact_type',_hudContactType())
                               ->count();
    }

   //  public function getHUDCount($hud_id) {
        // return $this->contacts->where('hud_id',$hud_id)
              //               ->count();
    // } 

    public function getHUDImageUpdatedCount($hud_id) {
         return $this->huds->where('id',$hud_id)
                            ->where('image_url','!=',NULL)
                            ->count();
    } 

    public function getHUDLocationUpdatedCount($hud_id) {
         return $this->huds->where('id',$hud_id)                               
                            ->where('location_url','!=',NULL)
                            ->count();
    }

    public function getHUDVideoUpdatedCount($hud_id) {
         return $this->huds->where('id',$hud_id)                               
                            ->where('video_url','!=',NULL)
                            ->count();
    }
    public function getHUDlandDocumentCount($hud_id) {
         return $this->huds->where('id',$hud_id)                               
                            ->where('property_document_url','!=',NULL)
                            ->count();
    }

    public function getBlockContactCount($hud_id) {
        return $this->contacts->where('hud_id',$hud_id)
                               ->where('block_id','!=',NULL)
                               ->where('user_id',NULL)
                               ->where('phc_id',NULL)
                               ->where('hsc_id',NULL)
                               ->where('contact_type',_blockContactType())
                               ->count();
    }

    public function getBlockCount($hud_id) {
     	 return $this->blocks->where('hud_id',$hud_id)
                             ->reject(function ($item) {
                                return Str::contains(strtolower($item['name']), ['mpty','corpn']);
                             })
     	 					 ->count();
    } 

    public function getBlockImageUpdatedCount($hud_id) {
     	 return $this->blocks->where('hud_id',$hud_id)
     	 					 ->where('image_url','!=',NULL)
                             ->reject(function ($item) {
                                return Str::contains(strtolower($item['name']), ['mpty','corpn']);
                             })
     	 					 ->count();
    } 

    public function getBlockLocationUpdatedCount($hud_id) {
     	 return $this->blocks->where('hud_id',$hud_id)
     	 					 ->where('location_url','!=',NULL)
                             ->reject(function ($item) {
                                return Str::contains(strtolower($item['name']), ['mpty','corpn']);
                             })
     	 					 ->count();
    }

    public function getBlockVideoUpdatedCount($hud_id) {
         return $this->blocks->where('hud_id',$hud_id)
                             ->where('video_url','!=',NULL)
                             ->reject(function ($item) {
                                return Str::contains(strtolower($item['name']), ['mpty','corpn']);
                             })
                             ->count();
    }

    public function getBlockLandDocumentCount($hud_id) {
         return $this->blocks->where('hud_id',$hud_id)
                             ->where('property_document_url','!=',NULL)
                             ->reject(function ($item) {
                                return Str::contains(strtolower($item['name']), ['mpty','corpn']);
                             })
                             ->count();
    }

    public function getPHCContactCount($hud_id) {
		$blockids = $this->blocks->where('hud_id', $hud_id)->pluck('id')->toArray() ?? [];
        return $this->contacts->where('hud_id',$hud_id)
                               ->whereIn('block_id',$blockids)
                               ->where('user_id',NULL)
                               ->where('phc_id','!=',NULL)
                               ->where('hsc_id',NULL)
                               ->where('contact_type',_phcContactType())
                               ->count();
    }

    public function getPHCCount($hud_id){
		$blockids = $this->blocks->where('hud_id', $hud_id)->pluck('id')->toArray() ?? [];
		return $this->phcs->whereIn('block_id',$blockids)->count() ?? 0;

    } 

    
    public function getPHCImageUpdatedCount($hud_id){
 		$blockids = $this->blocks->where('hud_id', $hud_id)->pluck('id')->toArray() ?? [];
		return $this->phcs->whereIn('block_id',$blockids)->where('image_url','!=',NULL)->count() ?? 0;

    }

    

    public function getPHCLocationUpdatedCount($hud_id){
		 $blockids = $this->blocks->where('hud_id', $hud_id)->pluck('id')->toArray() ?? [];
		 return $this->phcs->whereIn('block_id',$blockids)->where('location_url','!=',NULL)->count() ?? 0;

    }

    public function getPHCVideoUpdatedCount($hud_id){
         $blockids = $this->blocks->where('hud_id', $hud_id)->pluck('id')->toArray() ?? [];
         return $this->phcs->whereIn('block_id',$blockids)->where('video_url','!=',NULL)->count() ?? 0;

    }

    public function getPHCLandDocumentCount($hud_id){
         $blockids = $this->blocks->where('hud_id', $hud_id)->pluck('id')->toArray() ?? [];
         return $this->phcs->whereIn('block_id',$blockids)->where('property_document_url','!=',NULL)->count() ?? 0;

    }

    public function getHSCContactCount($hud_id) {
		$blockids = $this->blocks->where('hud_id', $hud_id)->pluck('id')->toArray() ?? [];
		$phcids = $this->phcs->whereIn('block_id', $blockids)->pluck('id')->toArray();
        return $this->contacts->where('hud_id',$hud_id)
                               ->whereIn('block_id',$blockids)
                               ->where('user_id',NULL)
                               ->whereIn('phc_id',$phcids)
                               ->where('hsc_id','!=',NULL)
                               ->where('contact_type',_hscContactType())
                               ->count();
    }

    public function getHSCCount($hud_id) {
     	$blockids = $this->blocks->where('hud_id', $hud_id)->pluck('id')->toArray() ?? [];
     	$phcids = $this->phcs->whereIn('block_id', $blockids)->pluck('id')->toArray();
		return $this->hscs->whereIn('phc_id',$phcids)->count() ?? 0;

    } 

    public function getHSCImageUpdatedCount($hud_id){
 		$blockids = $this->blocks->where('hud_id', $hud_id)->pluck('id')->toArray() ?? [];
		$phcids = $this->phcs->whereIn('block_id', $blockids)->pluck('id')->toArray();
		return $this->hscs->whereIn('phc_id',$phcids)->where('image_url','!=',NULL)->count() ?? 0;

    }

    public function getHSCLocationUpdatedCount($hud_id){
		$blockids = $this->blocks->where('hud_id', $hud_id)->pluck('id')->toArray() ?? [];
		$phcids = $this->phcs->whereIn('block_id', $blockids)->pluck('id')->toArray();
		return $this->hscs->whereIn('phc_id',$phcids)->where('location_url','!=',NULL)->count() ?? 0;

    }

    public function getHSCVideoUpdatedCount($hud_id){
        $blockids = $this->blocks->where('hud_id', $hud_id)->pluck('id')->toArray() ?? [];
        $phcids = $this->phcs->whereIn('block_id', $blockids)->pluck('id')->toArray();
        return $this->hscs->whereIn('phc_id',$phcids)->where('video_url','!=',NULL)->count() ?? 0;

    }

    public function getHSCLandDocumentCount($hud_id){
        $blockids = $this->blocks->where('hud_id', $hud_id)->pluck('id')->toArray() ?? [];
        $phcids = $this->phcs->whereIn('block_id', $blockids)->pluck('id')->toArray();
        return $this->hscs->whereIn('phc_id',$phcids)->where('property_document_url','!=',NULL)->count() ?? 0;

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



    public function backgroundColor()
    {
        // Return a Color instance. The fill type will automatically be set to "solid"
        return new Color(Color::COLOR_YELLOW);

    }

    public function title(): string
    {
        return 'One Report';
    }

}
