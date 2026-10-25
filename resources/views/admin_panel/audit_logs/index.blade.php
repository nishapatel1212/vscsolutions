@extends('layouts.app')

@section('title', 'Audit Log')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h1 class="page-title">Audit Log</h1>
        <p class="page-subtitle">Who changed what, and when</p>
    </div>
</div>
@endsection

@section('content')

<div class="panel mb-3">
    <div class="panel-header">
        <h5><i class="fas fa-filter me-2"></i> Filters</h5>
    </div>
    <div class="p-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-auto">
                <label class="form-label mb-1">Model</label>
                <select name="model" class="form-select form-select-sm">
                    <option value="">All</option>
                    @foreach($models as $key => $label)
                        <option value="{{ $key }}" {{ request('model') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <label class="form-label mb-1">Action</label>
                <select name="action" class="form-select form-select-sm">
                    <option value="">All</option>
                    <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Created</option>
                    <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Updated</option>
                    <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-gold btn-sm">Apply</button>
                <a href="{{ route('audit-logs.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <h5><i class="fas fa-history me-2"></i> Activity</h5>
    </div>

    <div class="table-responsive">
        <table class="table w-100">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Record</th>
                    <th>Changes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>{{ $log->created_at->format('d M Y, h:i A') }}</td>
                        <td>{{ $log->user->name ?? 'System' }}</td>
                        <td>
                            <span class="status-badge status-{{ $log->action == 'created' ? 'completed' : ($log->action == 'deleted' ? 'cancelled' : 'in_progress') }}">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td>{{ $log->auditableTypeLabel() }} — {{ $log->auditable_label }}</td>
                        <td>
                            @if($log->action == 'updated' && $log->new_values)
                                <ul class="mb-0 ps-3" style="font-size: 12px;">
                                    @foreach($log->new_values as $field => $value)
                                        @if(!in_array($field, ['updated_at']))
                                            <li>
                                                <strong>{{ $field }}:</strong>
                                                {{ is_array($value) ? json_encode($value) : ($value ?? '—') }}
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No activity recorded yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-3">
        {{ $logs->links() }}
    </div>
</div>

@endsection
