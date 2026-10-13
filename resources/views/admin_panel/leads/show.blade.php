@extends('layouts.app')

@section('title', 'Lead - ' . $lead->name)

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
    <h1 class="mb-0 page-title" style="font-size: 22px;">Lead: {{ $lead->name }}</h1>
    <a href="{{ route('leads.index') }}" class="btn-icon-round btn-icon-gray" title="Back">
        <i class="fas fa-arrow-left"></i>
    </a>
</div>
@endsection

@push('styles')
<style>
    .form-label {
        font-weight: 600;
        font-size: 13.5px;
        color: var(--latin-navy-deep);
        margin-bottom: 6px;
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

<div class="panel mb-4">
    <div class="panel-header">
        <h5><i class="fas fa-inbox me-2"></i> Inquiry Details</h5>
    </div>

    <div class="p-4">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Name</label>
                <p>{{ $lead->name }}</p>
            </div>
            <div class="col-md-6">
                <label class="form-label">Received</label>
                <p>{{ $lead->created_at->format('d M Y, H:i') }} ({{ ucfirst($lead->source) }})</p>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <p>{{ $lead->email ?? '—' }}</p>
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <p>{{ $lead->phone ?? '—' }}</p>
            </div>
            <div class="col-md-6">
                <label class="form-label">Auto-classified Job Type</label>
                <p>{{ $lead->job_type ?? 'Unclassified — add a matching keyword in Job Type Keywords if this job type recurs.' }}</p>
            </div>
            <div class="col-md-6">
                <label class="form-label">Linked Customer</label>
                <p>
                    @if($lead->customer)
                        <a href="{{ route('customer.show', $lead->customer->id) }}">{{ $lead->customer->name }}</a>
                    @else
                        Not linked yet
                    @endif
                </p>
            </div>
            <div class="col-12">
                <label class="form-label">Message</label>
                <p style="white-space: pre-wrap;">{{ $lead->message }}</p>
            </div>
        </div>
    </div>
</div>

<div class="panel mb-4">
    <div class="panel-header">
        <h5><i class="fas fa-tasks me-2"></i> Update Status</h5>
    </div>
    <div class="p-4">
        <form action="{{ route('leads.updateStatus', $lead->id) }}" method="POST" class="d-flex gap-2 flex-wrap">
            @csrf
            <select name="status" class="form-control" style="max-width: 220px;">
                @foreach(['new', 'contacted', 'quoted', 'converted', 'lost'] as $status)
                    <option value="{{ $status }}" {{ $lead->status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-outline-secondary">Update Status</button>
        </form>
    </div>
</div>

@if(!$lead->customer)
<div class="panel mb-4">
    <div class="panel-header">
        <h5><i class="fas fa-user-plus me-2"></i> Convert Lead</h5>
    </div>
    <div class="p-4">
        <form action="{{ route('leads.convert', $lead->id) }}" method="POST" class="row g-3 align-items-end">
            @csrf
            <div class="col-md-6">
                <label class="form-label">Link to Existing Customer (optional)</label>
                <select name="customer_id" class="form-control">
                    <option value="">-- Create new customer from this lead --</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }} @if($customer->phone)({{ $customer->phone }})@endif</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-gold">
                    <i class="fas fa-check me-1"></i> Convert &amp; Schedule Job
                </button>
            </div>
        </form>
        <small class="text-muted">This links the lead to a customer (creating one if needed) and takes you to schedule a job for them.</small>
    </div>
</div>
@endif

@endsection
