<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Customer;
use App\Models\SafetyCheckReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Certificate::with('customer')
                ->when($request->type, fn($q) => $q->where('type', $request->type))
                ->orderBy('id', 'desc');

            return DataTables::of($data)
                ->addIndexColumn()

                ->editColumn('type', function ($row) {
                    return $row->type === 'coes' ? 'COES' : 'Test & Tag';
                })

                ->editColumn('status', function ($row) {
                    $label = str_replace('_', ' ', ucfirst($row->status));
                    return '<span class="status-badge status-' . $row->status . '">' . $label . '</span>';
                })

                ->editColumn('issued_date', function ($row) {
                    return $row->issued_date->format('d-m-Y');
                })

                ->editColumn('expiry_date', function ($row) {
                    return $row->expiry_date ? $row->expiry_date->format('d-m-Y') : '—';
                })

                ->addColumn('actions', function ($row) {
                    $editUrl = route('certificates.edit', $row->id);
                    $deleteUrl = route('certificates.destroy', $row->id);
                    $pdfUrl = route('certificates.pdf', $row->id);

                    return '
                        <a href="' . $editUrl . '" class="text-yellow-500 mx-1 hover:text-yellow-700 transition-all" title="Edit">
                            <i class="fas fa-edit fa-lg"></i>
                        </a>

                        <form action="' . $deleteUrl . '" method="POST" style="display:inline-block;">
                            ' . csrf_field() . '
                            <button type="submit" class="text-red-500 mx-1 bg-transparent border-0 p-0 hover:text-red-700 transition-all" onclick="return confirm(\'Are you sure?\')" title="Delete">
                                <i class="fas fa-trash-alt fa-lg"></i>
                            </button>
                        </form>

                        <a href="' . $pdfUrl . '" class="text-green-500 mx-1 hover:text-green-700 transition-all" target="_blank" title="Download PDF">
                            <i class="fas fa-file-pdf fa-lg"></i>
                        </a>
                    ';
                })

                ->rawColumns(['actions', 'status'])
                ->make(true);
        }

        return view('admin_panel.certificates.index');
    }

    public function create(Request $request)
    {
        $type = $request->query('type') === 'test_and_tag' ? 'test_and_tag' : 'coes';
        $customers = Customer::orderBy('name')->get();
        $safetyCheckReports = SafetyCheckReport::orderBy('report_date', 'desc')->get();
        $certificate = null;

        return view('admin_panel.certificates.create', compact('type', 'customers', 'safetyCheckReports', 'certificate'));
    }

    public function store(Request $request)
    {
        $request->validate($this->rules($request));

        $certificate = Certificate::create([
            'type' => $request->type,
            'certificate_number' => Certificate::generateNumber($request->type),
            'customer_id' => $request->customer_id,
            'safety_check_report_id' => $request->safety_check_report_id,
            'client_name' => $request->client_name,
            'address' => $request->address,
            'issued_date' => $request->issued_date,
            'expiry_date' => $request->expiry_date,
            'electrician_name' => $request->electrician_name,
            'licence_number' => $request->licence_number,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        if ($request->type === 'test_and_tag') {
            $this->syncItems($certificate, $request);
        }

        return redirect()
            ->route('certificates.index')
            ->with('success', 'Certificate ' . $certificate->certificate_number . ' created successfully.');
    }

    public function edit($id)
    {
        $certificate = Certificate::with('items')->findOrFail($id);
        $type = $certificate->type;
        $customers = Customer::orderBy('name')->get();
        $safetyCheckReports = SafetyCheckReport::orderBy('report_date', 'desc')->get();

        return view('admin_panel.certificates.create', compact('type', 'customers', 'safetyCheckReports', 'certificate'));
    }

    public function update(Request $request, $id)
    {
        $certificate = Certificate::findOrFail($id);

        $request->validate($this->rules($request));

        $certificate->update([
            'customer_id' => $request->customer_id,
            'safety_check_report_id' => $request->safety_check_report_id,
            'client_name' => $request->client_name,
            'address' => $request->address,
            'issued_date' => $request->issued_date,
            'expiry_date' => $request->expiry_date,
            'electrician_name' => $request->electrician_name,
            'licence_number' => $request->licence_number,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        if ($certificate->type === 'test_and_tag') {
            $certificate->items()->delete();
            $this->syncItems($certificate, $request);
        }

        return redirect()
            ->route('certificates.index')
            ->with('success', 'Certificate updated successfully.');
    }

    public function destroy($id)
    {
        Certificate::findOrFail($id)->delete();

        return back()->with('success', 'Certificate deleted.');
    }

    public function downloadPdf($id)
    {
        $certificate = Certificate::with('items', 'customer', 'safetyCheckReport')->findOrFail($id);

        $pdf = Pdf::loadView('admin_panel.certificates.pdf', compact('certificate'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream($certificate->certificate_number . '.pdf');
    }

    private function rules(Request $request): array
    {
        return [
            'type' => 'required|in:coes,test_and_tag',
            'customer_id' => 'nullable|exists:customers,id',
            'safety_check_report_id' => 'nullable|exists:safety_check_reports,id',
            'client_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'issued_date' => 'required|date',
            'expiry_date' => 'nullable|date|after_or_equal:issued_date',
            'electrician_name' => 'nullable|string|max:255',
            'licence_number' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'items' => 'nullable|array',
            'items.*.appliance_name' => 'required_with:items|string|max:255',
            'items.*.tag_number' => 'nullable|string|max:255',
            'items.*.test_result' => 'nullable|in:pass,fail',
            'items.*.retest_date' => 'nullable|date',
            'items.*.notes' => 'nullable|string|max:255',
        ];
    }

    private function syncItems(Certificate $certificate, Request $request): void
    {
        foreach ($request->input('items', []) as $item) {
            if (empty($item['appliance_name'])) {
                continue;
            }

            $certificate->items()->create([
                'appliance_name' => $item['appliance_name'],
                'tag_number' => $item['tag_number'] ?? null,
                'test_result' => $item['test_result'] ?? 'pass',
                'retest_date' => $item['retest_date'] ?? null,
                'notes' => $item['notes'] ?? null,
            ]);
        }
    }
}
