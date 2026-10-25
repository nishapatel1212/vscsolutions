@extends('layouts.app')

@section('title', 'Add Permission')

@section('content_header')
<div>
    <h1 class="page-title">Add Permission</h1>
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

<form action="{{ route('permissions.store') }}" method="POST">
    @csrf

    <div class="panel mb-4">
        <div class="panel-header">
            <h5><i class="fas fa-key me-2"></i> Permission Details</h5>
        </div>

        <div class="p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Permission Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g. manage-invoices" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mb-5">
        <button type="submit" class="btn btn-gold btn-lg">
            <i class="fas fa-save"></i> Save Permission
        </button>
        <a href="{{ route('permissions.index') }}" class="btn btn-outline-secondary btn-lg">Cancel</a>
    </div>
</form>

@endsection
