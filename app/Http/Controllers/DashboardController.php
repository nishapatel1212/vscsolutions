<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Melbourne timezone
        $now = Carbon::now('Australia/Melbourne');

        // Total quotes
        $totalQuotes = Quote::count();

        // Quotes created this month
        $monthlyQuotes = Quote::whereYear(
            'quote_date',
            $now->year
        )
            ->whereMonth(
                'quote_date',
                $now->month
            )
            ->count();

        // Total value of all quotes
        $totalQuoteValue = Quote::sum('total');

        // Recent quotes
        $recentQuotes = Quote::latest('id')
            ->take(5)
            ->get();

        return view(
            'admin_panel.dashboard',
            compact(
                'totalQuotes',
                'monthlyQuotes',
                'totalQuoteValue',
                'recentQuotes'
            )
        );
    }
}
