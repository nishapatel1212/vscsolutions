<?php

namespace App\Http\Controllers;

use App\Models\EarthTestingItem;
use App\Models\Fault;
use App\Models\InspectionItem;
use App\Models\PolarityTestingItem;
use App\Models\SafetyCheckReport;
use App\Models\VisualInspectionItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $visual_inspection_items = VisualInspectionItem::all();
        $polarity_testing_items        = PolarityTestingItem::all();
        $earth_testing_items = EarthTestingItem::all();
        $data = null; // for create form
        return view('admin_panel.safety_check_report.create', compact('data', 'inspection_items', 'visual_inspection_items', 'polarity_testing_items', 'earth_testing_items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'report_date' => 'required|date',
            'details' => 'nullable|string',
            'safety_check_status' => 'required|string|max:255',
            'faults' => 'required|array',
            'faults.*.fault_name' => 'required|string|max:255',
        ], [
            'faults.*.fault_name.required' => 'Fault name is required.',
            'images.*.file'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'images.*.title'           => 'nullable|string|max:255',
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

            foreach ($faults as $index => $fault_arr) {
                Fault::create([
                    'report_id' => $report->id,
                    'fault' => $fault_arr['fault_name'],
                    'required_rectification' => $fault_arr['required_rectification'] ?? null,
                    'repair_completed' => $fault_arr['repair_completed'] ?? 0,
                    'assessment' => $fault_arr['assessment'] ?? null,
                ]);
            }
        }

        // attach selected items
        $report->inspectionItems()->sync($request->inspection_items ?? []);
        $report->inspectionItems()->sync($request->inspection_items ?? []);
        $report->polarityTestingItems()->sync($request->polarity_testing_items ?? []);
        $report->earthTestingItems()->sync($request->earth_testing_items ?? []);

        // Store Images
        if ($request->has('images')) {
            foreach ($request->images as $image) {
                if (!empty($image['file']) && isset($image['file']) && $image['file']->isValid()) {
                    $path = $image['file']->store('report_images', 'public');

                    $report->images()->create([
                        'title'      => $image['title'] ?? null,
                        'image_path' => $path,
                    ]);
                }
            }
        }

        return redirect()
            ->route('safetycheckreport.index')
            ->with('success', 'Safety Check Report created successfully');
    }

    public function edit($id)
    {
        $inspection_items = InspectionItem::all();
        $visual_inspection_items = VisualInspectionItem::all();
        $polarity_testing_items        = PolarityTestingItem::all();
        $earth_testing_items = EarthTestingItem::all();

        $data = SafetyCheckReport::findOrFail($id);
        return view('admin_panel.safety_check_report.create', compact('data', 'inspection_items', 'visual_inspection_items', 'polarity_testing_items', 'earth_testing_items'));
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
            'images.*.file'                    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'images.*.title'                   => 'nullable|string|max:255',
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

            foreach ($faults as $index => $d) {
                $faultId = $d['id'] ?? null;

                if ($faultId) {
                    // Update existing fault
                    $fault = $report->faults()->find($faultId);
                    if ($fault) {
                        $fault->update([
                            'fault' => $d['fault_name'],
                            'required_rectification' => $d['required_rectification'] ?? null,
                            'repair_completed' => $d['repair_completed'] ?? 0,
                            'assessment' => $d['assessment'] ?? null,
                        ]);
                    }
                } else {
                    // Create new fault
                    $report->faults()->create([
                        'fault' => $d['fault_name'],
                        'required_rectification' => $d['required_rectification'] ?? null,
                        'repair_completed' => $d['repair_completed'] ?? 0,
                        'assessment' => $d['assessment'] ?? null,
                    ]);
                }
            }
        }

        // inspection item
        $report->inspectionItems()->sync($request->inspection_items ?? []);
        $report->visualInspectionItems()->sync($request->visual_inspection_items ?? []);
        $report->polarityTestingItems()->sync($request->polarity_testing_items ?? []);
        $report->earthTestingItems()->sync($request->earth_testing_items ?? []);

        // 3️⃣ Update Images — only upload new ones, keep existing
        $images = $request->input('images', []);
        $imageFiles = $request->file('images', []);

        // Merge files into images array
        foreach ($imageFiles as $i => $fileData) {
            if (isset($fileData['file'])) {
                $images[$i]['file'] = $fileData['file'];
            }
        }

        if (!empty($images)) {

            // Get all image IDs submitted in the form (existing ones)
            $submittedImageIds = collect($images)
                ->pluck('id')
                ->filter()
                ->map(fn($id) => (int) $id)
                ->toArray();

            // Delete images that were removed from the form
            $removedImages = $report->images()->whereNotIn('id', $submittedImageIds)->get();
            foreach ($removedImages as $removed) {
                Storage::disk('public')->delete($removed->image_path);
                $removed->delete();
            }

            foreach ($images as $image) {
                $file = $image['file'] ?? null;

                // Skip if no new file uploaded
                if (!$file || !$file->isValid()) {
                    // Update title only if image_id exists
                    if (!empty($image['id'])) {
                        $report->images()->where('id', $image['id'])->update([
                            'title' => $image['title'] ?? null,
                        ]);
                    }
                    continue;
                }

                if (!empty($image['id'])) {
                    // Replace existing image
                    $existing = $report->images()->find($image['id']);
                    if ($existing) {
                        Storage::disk('public')->delete($existing->image_path);
                        $existing->update([
                            'title'      => $image['title'] ?? null,
                            'image_path' => $file->store('report_images', 'public'),
                        ]);
                    }
                } else {
                    // Brand new image
                    $report->images()->create([
                        'title'      => $image['title'] ?? null,
                        'image_path' => $file->store('report_images', 'public'),
                    ]);
                }
            }
        } else {
            // No images in form at all — remove all existing images
            foreach ($report->images as $removed) {
                Storage::disk('public')->delete($removed->image_path);
                $removed->delete();
            }
        }

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
        $eAllLeft    = EarthTestingItem::where('section', 'left')->get();
        $eAllRight   = EarthTestingItem::where('section', 'right')->get();

        $pdf = Pdf::loadView('admin_panel.safety_check_report.pdf', compact('data', 'eAllLeft', 'eAllRight'))
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

    public function addVisualInspectionItem(Request $request)
    {
        $item = VisualInspectionItem::create([
            'name' => $request->name,
            'key'  => Str::slug($request->name),
        ]);

        return response()->json($item);
    }

    public function addPolarityTestingItem(Request $request)
    {
        $item = PolarityTestingItem::create([
            'name' => $request->name,
            'key'  => Str::slug($request->name),
        ]);
        return response()->json($item);
    }

    public function addEarthTestingItem(Request $request)
    {
        $item = EarthTestingItem::create([
            'name' => $request->name,
            'key'  => Str::slug($request->name),
        ]);
        return response()->json($item);
    }
}
