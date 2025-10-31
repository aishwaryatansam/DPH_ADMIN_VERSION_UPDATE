<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\HUDReport;

class HudsExport implements WithMultipleSheets
{
    use Exportable;

    protected $year;

    public function __construct()
    {

    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $sheets['HUD Report'] = new HUDReport();
        $sheets['One Report'] = new HUDBasedUpdateCountReport();

        return $sheets;
    }
}
