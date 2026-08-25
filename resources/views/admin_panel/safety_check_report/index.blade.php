@extends('layouts.app')

@section('title', 'Safety Check Reports')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h1 class="page-title">Safety Check Reports</h1>
        <p class="page-subtitle">All completed and pending safety checks</p>
    </div>

    <a href="{{ route('safetycheckreport.create') }}" class="btn btn-gold">
        <i class="fas fa-plus"></i>
        Add Report
    </a>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

<style>
    .reports-table td.actions-cell {
        white-space: nowrap;
    }

    .reports-table td.actions-cell .btn-icon {
        margin-right: 4px;
    }

    /* Responsive extension's expand control, tinted to match brand */
    table.dtr-inline.collapsed > tbody > tr > td.dtr-control::before,
    table.dtr-inline.collapsed > tbody > tr > th.dtr-control::before {
        background-color: var(--latin-navy);
        border: 2px solid #fff;
        box-shadow: 0 0 3px rgba(0,0,0,0.2);
    }

    .dtr-details {
        list-style: none;
        padding: 0;
        margin: 8px 0 0;
    }

    .dtr-details li {
        padding: 6px 0;
        border-bottom: 1px solid var(--border-soft);
        font-size: 13px;
    }

    .dtr-details .dtr-title {
        font-weight: 700;
        color: var(--latin-navy-deep);
        display: inline-block;
        min-width: 110px;
    }

    @media (max-width: 575px) {
        .page-title {
            font-size: 22px;
        }
    }
</style>
@endpush

@section('content')

@if(session('success'))
    <div class="alert-soft alert-success mb-3">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert-soft alert-danger mb-3">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
    </div>
@endif

<div class="panel">

    <div class="panel-header">
        <h5><i class="fas fa-clipboard-check me-2"></i> All Reports</h5>
    </div>

    <div class="table-responsive">
        <table class="table data-table reports-table w-100" id="reportsTable">
            <thead>
                <tr>
                    <th>Actions</th>
                    <th>Client Name</th>
                    <th>Address</th>
                    <th>Date</th>
                    <th>Created</th>
                </tr>
            </thead>
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
    $('#reportsTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        pageLength: 10,
        ajax: "{{ route('safetycheckreport.index') }}",

        columns: [
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false
            },
            {
                data: 'client_name',
                name: 'client_name'
            },
            {
                data: 'address',
                name: 'address'
            },
            {
                data: 'report_date',
                name: 'report_date'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
        ],

        language: {
            search: "",
            searchPlaceholder: "Search reports...",
        }
    });
});
</script>
@endpush