@extends('layouts.app')

@section('title', 'Edit Job')

@section('content_header')
<div>
    <h1 class="page-title">Edit Job</h1>
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

@if($errors->any())
    <div class="alert-soft alert-danger mb-3">
        <ul class="mb-0 ps-3">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('jobs.update', $job->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="panel mb-4">
        <div class="panel-header">
            <h5><i class="fas fa-calendar-check me-2"></i> Job Details</h5>
        </div>

        <div class="p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $job->title) }}" required>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Scheduled Date <span class="text-danger">*</span></label>
                    <input type="date" name="scheduled_date" class="form-control @error('scheduled_date') is-invalid @enderror"
                           value="{{ old('scheduled_date', $job->scheduled_date->format('Y-m-d')) }}" required>
                    @error('scheduled_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label class="form-label">Customer</label>
                    <select name="customer_id" class="form-control">
                        <option value="">-- None --</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id', $job->customer_id) == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Linked Quote</label>
                    <select name="quote_id" class="form-control">
                        <option value="">-- None --</option>
                        @foreach($quotes as $quote)
                            <option value="{{ $quote->id }}" {{ old('quote_id', $job->quote_id) == $quote->id ? 'selected' : '' }}>
                                {{ $quote->quote_number }} — {{ $quote->customer_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label class="form-label">Technician</label>
                    <input type="text" name="technician" class="form-control" value="{{ old('technician', $job->technician) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        @foreach(['scheduled', 'in_progress', 'completed', 'cancelled'] as $status)
                            <option value="{{ $status }}" {{ old('status', $job->status) == $status ? 'selected' : '' }}>
                                {{ str_replace('_', ' ', ucfirst($status)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-12">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes', $job->notes) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mb-5">
        <button type="submit" class="btn btn-gold btn-lg">
            <i class="fas fa-save"></i> Update Job
        </button>
        <a href="{{ route('jobs.index') }}" class="btn btn-outline-secondary btn-lg">Cancel</a>
    </div>
</form>

@endsection
