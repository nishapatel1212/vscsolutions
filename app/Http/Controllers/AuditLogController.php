<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = AuditLog::with('user')
            ->when($request->action, fn($q) => $q->where('action', $request->action))
            ->when($request->model, fn($q) => $q->where('auditable_type', 'App\\Models\\' . $request->model))
            ->latest()
            ->paginate(50)
            ->withQueryString();

        $models = [
            'Customer' => 'Customer',
            'Quote' => 'Quote / Invoice',
            'Invoice' => 'Invoice',
            'ServiceJob' => 'Service Job',
            'Lead' => 'Lead',
            'SafetyCheckReport' => 'Safety Check Report',
        ];

        return view('admin_panel.audit_logs.index', compact('logs', 'models'));
    }
}
