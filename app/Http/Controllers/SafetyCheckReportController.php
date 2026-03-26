<?php

namespace App\Http\Controllers;

use App\Models\SafetyCheckReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SafetyCheckReportController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SafetyCheckReport::latest()->select('*');

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('actions', function ($row) {
                    $editUrl = route('safetycheckreport.edit', $row->id);
                    $deleteUrl = route('safetycheckreport.destroy', $row->id);
                    $pdfUrl = route('safetycheckreport.pdf', $row->id);

                    return '
                        <a href="' . $editUrl . '" class="text-yellow-500 mx-1 hover:text-yellow-700 transition-all" title="Edit">
                            <i class="fas fa-edit fa-lg"></i>
                        </a>

                        <form action="' . $deleteUrl . '" method="POST" style="display:inline-block;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="text-red-500 mx-1 bg-transparent border-0 p-0 hover:text-red-700 transition-all" onclick="return confirm(\'Are you sure?\')" title="Delete">
                                <i class="fas fa-trash-alt fa-lg"></i>
                            </button>
                        </form>

                        <a href="' . $pdfUrl . '" class="text-green-500 mx-1 hover:text-green-700 transition-all" target="_blank" title="Download PDF">
                            <i class="fas fa-file-pdf fa-lg"></i>
                        </a>
                    ';
                })

                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d-m-Y');
                })

                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin_panel.safety_check_report.index');
    }

    public function create()
    {
        return view('admin_panel.safety_check_report.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'report_date' => 'required|date',
            'details' => 'nullable|string',
        ]);

        SafetyCheckReport::create([
            'address' => $request->address,
            'report_date' => $request->report_date,
            'details' => $request->details,
        ]);

        return redirect()
            ->route('safetycheckreport.index')
            ->with('success', 'Safety Check Report created successfully');
    }

    public function edit($id)
    {
        $report = SafetyCheckReport::findOrFail($id);
        return view('admin_panel.property_reports.edit', compact('report'));
    }

    public function update(Request $request, $id)
    {
        $report = SafetyCheckReport::findOrFail($id);
        $report->update($request->all());
        return redirect()->route('property-reports.index')->with('success', 'Updated Successfully');
    }

    public function destroy($id)
    {
        SafetyCheckReport::findOrFail($id)->delete();
        return back()->with('success', 'Deleted Successfully');
    }

    public function downloadPdf($id)
    {
        $data = SafetyCheckReport::findOrFail($id);

        $pdf = Pdf::loadView('admin_panel.safety_check_report.pdf', compact('data'))
            ->setPaper('A4', 'portrait');

        // return $pdf->download('safety-check-report-' . $id . '.pdf');
        return $pdf->stream('safety-check-report-' . $id . '.pdf');
    }
}
