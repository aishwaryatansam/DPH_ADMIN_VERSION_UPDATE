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

        DB::table('visitors')->insert([
            'ip_address' => $ip,
            'page_url' => $pageUrl,
            'visited_at' => now()
        ]);

        $totalVisitors = DB::table('visitors')
            ->distinct('ip_address')
            ->count('ip_address');

        $pageVisitors = DB::table('visitors')
            ->where('page_url', $pageUrl)
            ->distinct('ip_address')
            ->count('ip_address');

        return response()->json([
            'totalVisitors' => $totalVisitors,
            'pageVisitors' => $pageVisitors
        ]);
    }
}
