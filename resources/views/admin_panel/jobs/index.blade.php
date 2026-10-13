@extends('layouts.app')

@section('title', 'Jobs')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h1 class="page-title">Scheduled Jobs</h1>
        <p class="page-subtitle">Upcoming and past work</p>
    </div>

    <a href="{{ route('jobs.create') }}" class="btn btn-gold">
        <i class="fas fa-plus"></i>
        Schedule Job
    </a>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<style>
    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }
    .status-scheduled { background: #e7f1ff; color: #2563eb; }
    .status-in_progress { background: #fff4e5; color: #b45309; }
    .status-completed { background: #e8f8ee; color: #1a7f45; }
    .status-cancelled { background: #fde8e8; color: #c0392b; }
</style>
@endpush

@section('content')

@if(session('success'))
    <div class="alert-soft alert-success mb-3">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif

<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5><i class="fas fa-calendar-check me-2"></i> All Jobs</h5>

        <div class="btn-group">
            <a href="{{ route('jobs.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-gold' : 'btn-outline-secondary' }}">All</a>
            <a href="{{ route('jobs.index', ['status' => 'scheduled']) }}" class="btn btn-sm {{ request('status') == 'scheduled' ? 'btn-gold' : 'btn-outline-secondary' }}">Scheduled</a>
            <a href="{{ route('jobs.index', ['status' => 'in_progress']) }}" class="btn btn-sm {{ request('status') == 'in_progress' ? 'btn-gold' : 'btn-outline-secondary' }}">In Progress</a>
            <a href="{{ route('jobs.index', ['status' => 'completed']) }}" class="btn btn-sm {{ request('status') == 'completed' ? 'btn-gold' : 'btn-outline-secondary' }}">Completed</a>
            <a href="{{ route('jobs.index', ['status' => 'cancelled']) }}" class="btn btn-sm {{ request('status') == 'cancelled' ? 'btn-gold' : 'btn-outline-secondary' }}">Cancelled</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table data-table w-100" id="jobsTable">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Customer</th>
                    <th>Technician</th>
                    <th>Quote</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobs as $job)
                    <tr>
                        <td>{{ $job->scheduled_date->format('d M Y') }}</td>
                        <td>{{ $job->title }}</td>
                        <td>{{ $job->customer->name ?? '—' }}</td>
                        <td>{{ $job->technician ?? '—' }}</td>
                        <td>
                            @if($job->quote)
                                <a href="{{ route('quote.show', $job->quote->id) }}">{{ $job->quote->quote_number }}</a>
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            <span class="status-badge status-{{ $job->status }}">
                                {{ str_replace('_', ' ', $job->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('jobs.edit', $job->id) }}" class="btn-icon btn-icon-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this job?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon" title="Delete" style="border:none;background:none;color:var(--danger);">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#jobsTable').DataTable({
        order: [[0, 'asc']],
        pageLength: 25,
        responsive: true,
        language: {
            search: "",
            searchPlaceholder: "Search jobs...",
            emptyTable: "No jobs scheduled yet."
        }
    });
});
</script>
@endpush
