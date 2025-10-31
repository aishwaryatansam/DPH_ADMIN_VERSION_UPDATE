<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RTI_PDF extends Model
{
    protected $table = 'rti_pdfs'; // Table name

    protected $fillable = [
        'file_name',
        'file_path',
        'upload_date',
    ];

    public static function getRtiPdfData(){
        return static::orderBy('upload_date', 'desc')->first();
    }
}
