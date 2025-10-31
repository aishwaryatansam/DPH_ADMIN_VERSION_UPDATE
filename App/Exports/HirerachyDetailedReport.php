<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\CountReport\HUDCountReport;
use App\Exports\CountReport\BlockCountReport;
use App\Exports\CountReport\PHCCountReport;
use App\Exports\CountReport\HSCCountReport;
use App\Models\HUD;
use App\Models\Block;
use App\Models\PHC;
use App\Models\HSC;
use App\Models\Contact;

class HirerachyDetailedReport implements WithMultipleSheets
{
    use Exportable;

    private $huds;
    private $blocks;
    private $phcs;
    private $hscs;
    private $contacts;
    private $contactTypes = [];
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
        $this->huds = HUD::filter()->where('status',_active())->orderBy('name')->get();

        $this->contactTypes[] = _hudContactType();

        if($this->type == 'block')
        {
            $this->contactTypes[] = _blockContactType();
            $this->blocks = $this->getBlocks();
        }

        if($this->type == 'phc')
        {
            $this->contactTypes[] = _phcContactType();
            $this->blocks = $this->getBlocks();
            $this->phcs = $this->getPhc();
        }

        if($this->type == 'hsc')
        {
            $this->contactTypes[] = _hscContactType();
            $this->blocks = $this->getBlocks();
            $this->phcs = $this->getPhc();
            $this->hscs = $this->getHsc();
        }

        $this->contacts = Contact::select('id','name','status','contact_type','hud_id','block_id','phc_id','hsc_id')->where('status',_active())->whereIn('contact_type',$this->contactTypes)->get();
    }

    public function getBlocks()
    {
        return Block::select('id','name','status','hud_id','image_url','location_url','video_url')->whereIn('hud_id', $this->huds->pluck('id'))->where('status',_active())->orderBy('name')->get();
    }

    public function getPhc()
    {
        return PHC::select('id','name','status','block_id','image_url','location_url','video_url')->whereIn('block_id', $this->blocks->pluck('id'))->where('status',_active())->orderBy('name')->get();
    }

    public function getHsc()
    {
        return HSC::select('id','name','status','phc_id','image_url','location_url','video_url')->whereIn('phc_id', $this->phcs->pluck('id'))->where('status',_active())->orderBy('name')->get();
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        if($this->type == 'hud') 
        {
            $hudContacts = $this->contacts->where('contact_type',_hudContactType());
            $sheets['HUD Report'] = new HUDCountReport($this->huds, $hudContacts);
        }
        if($this->type == 'block') 
        {
            $blockContacts = $this->contacts->where('contact_type',_blockContactType());
            $sheets['Block Report'] = new BlockCountReport($this->huds, $this->blocks, $blockContacts);    
        }
        if($this->type == 'phc') 
        {
            $phcContacts = $this->contacts->where('contact_type',_phcContactType());
            $sheets['PHC Report'] = new PHCCountReport($this->huds, $this->blocks, $this->phcs, $phcContacts);    
        }
        if($this->type == 'hsc') 
        {
            $hscContacts = $this->contacts->where('contact_type',_hscContactType());
            $sheets['HSC Report'] = new HSCCountReport($this->huds, $this->blocks, $this->phcs, $this->hscs, $hscContacts);    
        }

        return $sheets;
    }
}

