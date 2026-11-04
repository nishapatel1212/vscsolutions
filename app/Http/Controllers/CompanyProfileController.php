<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use Illuminate\Http\Request;

class CompanyProfileController extends Controller
{
    public function edit()
    {
        $company = CompanySetting::current();

        return view('admin_panel.settings.company_profile.edit', compact('company'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'abn' => 'nullable|string|max:255',
            'rec_number' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'service_area' => 'nullable|string|max:1000',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'electrician_name' => 'nullable|string|max:255',
            'insurance_line' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_name' => 'nullable|string|max:255',
            'bank_bsb' => 'nullable|string|max:50',
            'bank_account_number' => 'nullable|string|max:50',
            'payment_reference_note' => 'nullable|string|max:255',
            'logo_path' => 'nullable|string|max:255',
            'logo_dark_path' => 'nullable|string|max:255',
            'favicon_path' => 'nullable|string|max:255',
        ]);

        $company = CompanySetting::current();

        if ($company->exists) {
            $company->update($request->all());
        } else {
            CompanySetting::create($request->all());
        }

        return redirect()->route('settings.company-profile.edit')->with('success', 'Company profile updated successfully.');
    }
}
