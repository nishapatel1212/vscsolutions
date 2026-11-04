<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use App\Models\JobTypeKeyword;
use App\Models\QuotePriceItem;

class SettingsController extends Controller
{
    public function index()
    {
        $keywordCount = JobTypeKeyword::count();
        $priceItemCount = QuotePriceItem::count();
        $company = CompanySetting::current();

        return view('admin_panel.settings.index', compact('keywordCount', 'priceItemCount', 'company'));
    }
}
