@extends('layouts.app')

@section('title', 'Send Email Template')

@section('content_header')
<div>
    <h1 class="page-title">Send: {{ $template->name }}</h1>
    <p class="page-subtitle">Subject: {{ $template->subject }}</p>
</div>
@endsection

@section('content')

@if($errors->any())
    <div class="alert-soft alert-danger mb-3">
        <ul class="mb-0 ps-3">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('email-templates.send', $template->id) }}" method="POST" id="sendTemplateForm" data-confirm="Send this email to the selected customers?">
    @csrf

    <div class="panel mb-4">
        <div class="panel-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5><i class="fas fa-users me-2"></i> Select Customers</h5>
            <input type="text" id="customerSearch" class="form-control form-control-sm" style="max-width: 240px;" placeholder="Search customers...">
        </div>

        <div class="p-4">
            @if($customers->isEmpty())
                <p class="text-muted mb-0">No customers with an email address yet.</p>
            @else
                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" id="selectAllCustomers" class="form-check-input">
                        <label class="form-check-label fw-bold" for="selectAllCustomers">Select All</label>
                    </div>
                </div>

                <div class="row" id="customerList">
                    @foreach($customers as $customer)
                        <div class="col-md-4 mb-2 customer-row" data-search="{{ strtolower($customer->name . ' ' . $customer->email) }}">
                            <div class="form-check">
                                <input type="checkbox" name="customer_ids[]" value="{{ $customer->id }}" class="form-check-input customer-checkbox" id="cust{{ $customer->id }}">
                                <label class="form-check-label" for="cust{{ $customer->id }}">
                                    {{ $customer->name }} <small class="text-muted">({{ $customer->email }})</small>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="text-center mb-5">
        <button type="submit" class="btn btn-gold btn-lg">
            <i class="fas fa-paper-plane"></i> Send Email
        </button>
        <a href="{{ route('email-templates.index') }}" class="btn btn-outline-secondary btn-lg">Cancel</a>
    </div>
</form>

@endsection

@push('scripts')
<script src="{{ asset('js/pages/email-template-send.js') }}"></script>
@endpush
