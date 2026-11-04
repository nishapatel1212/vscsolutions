@extends('layouts.app')

@section('title', 'Jobs Calendar')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h1 class="page-title">Jobs Calendar</h1>
        <p class="page-subtitle">Scheduled work at a glance</p>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('jobs.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-list"></i>
            List View
        </a>
        <a href="{{ route('jobs.create') }}" class="btn btn-danger">
            <i class="fas fa-bolt"></i>
            Urgent Callout
        </a>
        <a href="{{ route('jobs.create') }}" class="btn btn-gold">
            <i class="fas fa-plus"></i>
            Schedule Job
        </a>
    </div>
</div>
@endsection

@section('content')

<div class="panel">
    <div class="panel-header">
        <div class="status-legend">
            <span><span class="dot" style="background:#2563eb;"></span> Scheduled</span>
            <span><span class="dot" style="background:#b45309;"></span> In Progress</span>
            <span><span class="dot" style="background:#1a7f45;"></span> Completed</span>
            <span><span class="dot" style="background:#c0392b;"></span> Cancelled</span>
        </div>
        <small class="text-muted d-block mt-2">Drag a job to reschedule it, resize to adjust duration, or click an empty slot to book a job into that time.</small>
    </div>
    <div class="p-3">
        <div id="calendar"
             data-events-url="{{ route('jobs.calendarEvents') }}"
             data-create-url="{{ route('jobs.create') }}"
             data-reschedule-url-template="{{ route('jobs.reschedule', ['id' => '__ID__']) }}"></div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/pages/jobs-calendar.js') }}"></script>
@endpush
