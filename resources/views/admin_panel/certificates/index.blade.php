@extends('layouts.app')

@section('title', 'Compliance Certificates')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h1 class="page-title page-title-sm">Compliance Certificates</h1>
        <p class="page-subtitle">COES and Test &amp; Tag records</p>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('certificates.create', ['type' => 'test_and_tag']) }}" class="btn btn-outline-secondary">
            <i class="fas fa-tag"></i>
            New Test &amp; Tag
        </a>
        <a href="{{ route('certificates.create', ['type' => 'coes']) }}" class="btn btn-gold">
            <i class="fas fa-certificate"></i>
            New COES
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

    <div class="panel-header">
        <div class="status-legend">
            <a href="{{ route('certificates.index') }}" class="btn btn-sm {{ request('type') ? 'btn-outline-secondary' : 'btn-gold' }}">All</a>
            <a href="{{ route('certificates.index', ['type' => 'coes']) }}" class="btn btn-sm {{ request('type') == 'coes' ? 'btn-gold' : 'btn-outline-secondary' }}">COES</a>
            <a href="{{ route('certificates.index', ['type' => 'test_and_tag']) }}" class="btn btn-sm {{ request('type') == 'test_and_tag' ? 'btn-gold' : 'btn-outline-secondary' }}">Test &amp; Tag</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table data-table data-table-striped reports-table w-100" id="certificatesTable"
               data-ajax-url="{{ route('certificates.index', ['type' => request('type')]) }}">
            <thead>
                <tr>
                    <th>Actions</th>
                    <th>Certificate #</th>
                    <th>Type</th>
                    <th>Client Name</th>
                    <th>Address</th>
                    <th>Issued</th>
                    <th>Expiry</th>
                    <th>Status</th>
                </tr>
            </thead>
        </table>
    </div>

</div>

@endsection

@push('scripts')
<script src="{{ asset('js/pages/certificates-index.js') }}"></script>
@endpush
