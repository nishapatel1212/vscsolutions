@extends('layouts.app')

@section('title', 'SMS Send Log')

@section('content_header')
<div class="mb-4">
    <h1 class="page-title page-title-sm">Send Log: {{ $template->name }}</h1>
</div>
@endsection

@section('content')

<div class="panel">
    <div class="panel-header">
        <h5><i class="fas fa-list me-2"></i> Send History</h5>
    </div>

    <div class="table-responsive">
        <table class="table data-table data-table-striped w-100">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>{{ $log->created_at->format('d M Y, h:i A') }}</td>
                        <td>{{ $log->customer->name ?? '—' }}</td>
                        <td>{{ $log->phone }}</td>
                        <td>
                            <span class="status-badge status-{{ $log->status === 'sent' ? 'completed' : ($log->status === 'failed' ? 'cancelled' : 'in_progress') }}">
                                {{ $log->status }}
                            </span>
                            @if($log->status === 'failed' && $log->error)
                                <br><small class="text-muted">{{ $log->error }}</small>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No messages sent yet for this template.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-3">
        {{ $logs->links() }}
    </div>
</div>

<div class="text-center mb-5">
    <a href="{{ route('sms-templates.index') }}" class="btn btn-outline-secondary">Back to Templates</a>
</div>

@endsection
