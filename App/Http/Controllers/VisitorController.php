<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitorController extends Controller
{
    public function trackVisitor(Request $request)
    {
        $ip = $request->ip();
        $pageUrl = $request->input('page_url');

        // Insert the visitor data into the database
        DB::table('visitors')->insert([
            'ip_address' => $ip,
            'page_url' => $pageUrl,
            'visited_at' => now()
        ]);

        return response()->json(['message' => 'Visitor tracked successfully']);
    }

    public function getVisitorCount()
    {
        // Get the total count of visitors
        $count = DB::table('visitors')->count();
        return response()->json(['total_visitors' => $count]);
    }
}
