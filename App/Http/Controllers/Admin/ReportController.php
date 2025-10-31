<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function reportView()
    {
        return view('admin.reports.reports');
    }
}
