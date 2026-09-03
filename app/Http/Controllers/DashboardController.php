<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now('Australia/Melbourne');

        // Only count actual quotes, not invoices
        $totalQuotes = Quote::where('type', '!=', 'invoice')->count();

        $monthlyQuotes = Quote::where('type', '!=', 'invoice')
            ->whereYear('quote_date', $now->year)
            ->whereMonth('quote_date', $now->month)
            ->count();

        $totalQuoteValue = Quote::where('type', '!=', 'invoice')->sum('total');

        // Recent quotes, each with its invoice (if any) eager loaded
        $recentQuotes = Quote::with('invoiceCopy')
            ->where('type', '!=', 'invoice')
            ->latest('id')
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
