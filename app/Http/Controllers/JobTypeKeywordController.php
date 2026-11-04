<?php

namespace App\Http\Controllers;

use App\Models\JobTypeKeyword;
use Illuminate\Http\Request;

class JobTypeKeywordController extends Controller
{
    public function index()
    {
        $keywords = JobTypeKeyword::orderBy('job_type')->orderBy('keyword')->get();

        return view('admin_panel.settings.job_keywords.index', compact('keywords'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string|max:255|unique:job_type_keywords,keyword',
            'job_type' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
        ]);

        JobTypeKeyword::create([
            'keyword' => strtolower($request->keyword),
            'job_type' => $request->job_type,
            'category' => $request->category,
            'active' => true,
        ]);

        return redirect()->route('settings.job-keywords.index')->with('success', 'Keyword added successfully.');
    }

    public function update(Request $request, $id)
    {
        $keyword = JobTypeKeyword::findOrFail($id);

        $request->validate([
            'keyword' => 'required|string|max:255|unique:job_type_keywords,keyword,' . $keyword->id,
            'job_type' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
        ]);

        $keyword->update([
            'keyword' => strtolower($request->keyword),
            'job_type' => $request->job_type,
            'category' => $request->category,
            'active' => $request->boolean('active'),
        ]);

        return redirect()->route('settings.job-keywords.index')->with('success', 'Keyword updated successfully.');
    }

    public function destroy($id)
    {
        JobTypeKeyword::findOrFail($id)->delete();

        return redirect()->route('settings.job-keywords.index')->with('success', 'Keyword deleted.');
    }
}
