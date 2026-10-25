@extends('layouts.app')

@section('title', 'Safety Check Reports')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h1 class="page-title">Safety Check Reports</h1>
    </div>

    <a href="{{ route('safetycheckreport.create') }}" class="btn btn-gold">
        <i class="fas fa-plus"></i>
        Add Report
    </a>
</div>
@endsection

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
        <table class="table data-table reports-table w-100" id="reportsTable" data-ajax-url="{{ route('safetycheckreport.index') }}">
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
<script src="{{ asset('js/pages/safety-check-index.js') }}"></script>
@endpush