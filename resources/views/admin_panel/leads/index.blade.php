@extends('layouts.app')

@section('title', 'Leads')

@section('content_header')
<div>
    <h1 class="page-title">Leads</h1>
    <p class="page-subtitle">Inquiries from the website and other sources</p>
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
        <h5><i class="fas fa-inbox me-2"></i> All Leads</h5>

        <div class="btn-group">
            <a href="{{ route('leads.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-gold' : 'btn-outline-secondary' }}">All</a>
            <a href="{{ route('leads.index', ['status' => 'new']) }}" class="btn btn-sm {{ request('status') == 'new' ? 'btn-gold' : 'btn-outline-secondary' }}">New</a>
            <a href="{{ route('leads.index', ['status' => 'contacted']) }}" class="btn btn-sm {{ request('status') == 'contacted' ? 'btn-gold' : 'btn-outline-secondary' }}">Contacted</a>
            <a href="{{ route('leads.index', ['status' => 'quoted']) }}" class="btn btn-sm {{ request('status') == 'quoted' ? 'btn-gold' : 'btn-outline-secondary' }}">Quoted</a>
            <a href="{{ route('leads.index', ['status' => 'converted']) }}" class="btn btn-sm {{ request('status') == 'converted' ? 'btn-gold' : 'btn-outline-secondary' }}">Converted</a>
            <a href="{{ route('leads.index', ['status' => 'lost']) }}" class="btn btn-sm {{ request('status') == 'lost' ? 'btn-gold' : 'btn-outline-secondary' }}">Lost</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table data-table w-100" id="leadsTable">
            <thead>
                <tr>
                    <th>Received</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Job Type</th>
                    <th>Source</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leads as $lead)
                    <tr>
                        <td>{{ $lead->created_at->format('d M Y H:i') }}</td>
                        <td>{{ $lead->name }}</td>
                        <td>{{ $lead->phone ?? $lead->email ?? '—' }}</td>
                        <td>{{ $lead->job_type ?? 'Unclassified' }}</td>
                        <td>{{ ucfirst($lead->source) }}</td>
                        <td>
                            <span class="status-badge status-{{ $lead->status }}">{{ $lead->status }}</span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('leads.show', $lead->id) }}" class="btn-icon" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
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
    initDataTable('#leadsTable', {
        order: [[0, 'desc']],
        language: {
            search: '',
            searchPlaceholder: 'Search leads...',
            emptyTable: 'No leads yet.'
        }
    });
});
</script>
@endpush
