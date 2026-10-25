@extends('layouts.app')

@section('title', 'Jobs')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h1 class="page-title">Scheduled Jobs</h1>
        <p class="page-subtitle">Upcoming and past work</p>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('jobs.calendar') }}" class="btn btn-outline-secondary">
            <i class="fas fa-calendar-alt"></i>
            Calendar View
        </a>
        <a href="{{ route('jobs.create') }}" class="btn btn-gold">
            <i class="fas fa-plus"></i>
            Schedule Job
        </a>
    </div>
</div>
@endsection

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
                            <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" class="d-inline" data-confirm="Delete this job?">
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
<script>
$(document).ready(function () {
    initDataTable('#jobsTable', {
        order: [[0, 'asc']],
        language: {
            search: '',
            searchPlaceholder: 'Search jobs...',
            emptyTable: 'No jobs scheduled yet.'
        }
    });
});
</script>
@endpush
