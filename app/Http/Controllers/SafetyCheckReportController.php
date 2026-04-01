<?php

namespace App\Http\Controllers;

use App\Models\Fault;
use App\Models\InspectionItem;
use App\Models\SafetyCheckReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
        $inspection_items = InspectionItem::all();
        return view('admin_panel.safety_check_report.create', compact('inspection_items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'report_date' => 'required|date',
            'details' => 'nullable|string',
            'safety_check_status' => 'required|string|max:255',
        ]);

        $report = SafetyCheckReport::create([
            'address' => $request->address,
            'report_date' => $request->report_date,
            'previous_safety_date' => $request->previous_safety_date,
            'details' => $request->details,
            'safety_check_status' => $request->safety_check_status,
        ]);

        // 2️⃣ Store Multiple Faults
        if ($request->has('faults')) {
            $faults = $request->faults;

            foreach ($faults['fault_name'] as $index => $faultName) {
                Fault::create([
                    'report_id' => $report->id,
                    'fault' => $faultName,
                    'required_rectification' => $faults['required_rectification'][$index] ?? null,
                    'repair_completed' => $faults['repair_completed'][$index] ?? 0,
                    'assessment' => $faults['assessment'][$index] ?? null,
                ]);
            }
        }

        // attach selected items
        $report->inspectionItems()->sync($request->inspection_items ?? []);

        return redirect()
            ->route('safetycheckreport.index')
            ->with('success', 'Safety Check Report created successfully');
    }

    public function edit($id)
    {
        $inspection_items = InspectionItem::all();
        $data = SafetyCheckReport::findOrFail($id);
        return view('admin_panel.safety_check_report.create', compact('data', 'inspection_items'));
    }

    public function update(Request $request)
    {
        $id = $request->id ?? '';

        $request->validate([
            'address' => 'required|string|max:255',
            'report_date' => 'required|date',
            'details' => 'nullable|string',
            'safety_check_status' => 'required|string|max:255',

            'faults.id.*' => 'nullable|exists:faults,id', // optional, only if updating existing fault
            'faults.fault_name.*' => 'required|string',
            'faults.required_rectification.*' => 'required|string',
            'faults.repair_completed.*' => 'required|in:0,1',
            'faults.assessment.*' => 'nullable|string',
        ]);

        // 1️⃣ Update main Report
        $report = SafetyCheckReport::findOrFail($id);

        $report->update([
            'address' => $request->address,
            'report_date' => $request->report_date,
            'previous_safety_date' => $request->previous_safety_date,
            'details' => $request->details,
            'safety_check_status' => $request->safety_check_status,
        ]);

        // 2️⃣ Update or create faults
        if ($request->has('faults')) {
            $faults = $request->faults;

            foreach ($faults['fault_name'] as $index => $faultName) {
                $faultId = $faults['id'][$index] ?? null;

                if ($faultId) {
                    // Update existing fault
                    $fault = $report->faults()->find($faultId);
                    if ($fault) {
                        $fault->update([
                            'fault' => $faultName,
                            'required_rectification' => $faults['required_rectification'][$index] ?? null,
                            'repair_completed' => $faults['repair_completed'][$index] ?? 0,
                            'assessment' => $faults['assessment'][$index] ?? null,
                        ]);
                    }
                } else {
                    // Create new fault
                    $report->faults()->create([
                        'fault' => $faultName,
                        'required_rectification' => $faults['required_rectification'][$index] ?? null,
                        'repair_completed' => $faults['repair_completed'][$index] ?? 0,
                        'assessment' => $faults['assessment'][$index] ?? null,
                    ]);
                }
            }
        }

        // inspection item
        $report->inspectionItems()->sync($request->inspection_items ?? []);

        return redirect()
            ->route('safetycheckreport.index')
            ->with('success', 'Updated Successfully');
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

    public function addInspectionItem(Request $request)
    {
        $item = InspectionItem::create([
            'name' => $request->name,
            'key' => Str::slug($request->name),
        ]);

        return response()->json($item);
    }
}
