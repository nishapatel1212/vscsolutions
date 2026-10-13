@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content_header')
<div>
    <h1 class="page-title">Edit Customer</h1>
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

<form action="{{ route('customer.update', $data->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="panel mb-4">
        <div class="panel-header">
            <h5><i class="fas fa-user me-2"></i> Customer Details</h5>
        </div>

        <div class="p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $data->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control"     value="{{ old('phone', $data->phone) }}">
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"     value="{{ old('email', $data->email) }}">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="1">{{ old('address', $data->address) }}</textarea>
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-12">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes', $data->notes) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mb-5">
        <button type="submit" class="btn btn-gold btn-lg">
            <i class="fas fa-save"></i> Save Customer
        </button>
        <a href="{{ route('customer.index') }}" class="btn btn-outline-secondary btn-lg">Cancel</a>
    </div>
</form>

@endsection