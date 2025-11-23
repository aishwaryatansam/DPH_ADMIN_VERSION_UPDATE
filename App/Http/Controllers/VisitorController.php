<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Visitor;
use Carbon\Carbon;

class VisitorController extends Controller
{
    public function trackVisitor(Request $request)
    {
        $ip = $request->ip(); // User IP
        $pageUrl = $request->input('page_url', '/');

        // Check if this IP already visited today
        $alreadyVisited = Visitor::where('ip_address', $ip)
            ->whereDate('visited_at', Carbon::today())
            ->exists();

        if (!$alreadyVisited) {
            Visitor::create([
                'ip_address' => $ip,
                'page_url' => $pageUrl,
                'visited_at' => now()
            ]);
        }

        return response()->json(['message' => 'Visitor tracked']);
    }

    public function getVisitorCount()
    {
        $count = Visitor::count();
        return response()->json(['total_visitors' => $count]);
    }
}
