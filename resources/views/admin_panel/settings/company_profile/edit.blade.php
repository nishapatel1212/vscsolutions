@extends('layouts.app')

@section('title', 'Company Profile')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h1 class="page-title">Company Profile</h1>
        <p class="page-subtitle">Shown on every quote, invoice, PDF, email, and the chatbot</p>
    </div>
    <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Settings
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

@if($errors->any())
    <div class="alert-soft alert-danger mb-3">
        <ul class="mb-0 ps-3">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('settings.company-profile.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="panel mb-4">
        <div class="panel-header">
            <h5><i class="fas fa-building me-2"></i> Business Details</h5>
        </div>
        <div class="p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Company Name <span class="text-danger">*</span></label>
                    <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name', $company->company_name) }}" required>
                    @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Owner / Electrician Name</label>
                    <input type="text" name="electrician_name" class="form-control" value="{{ old('electrician_name', $company->electrician_name) }}">
                </div>
            </div>
            <div class="row g-3 mt-1">
                <div class="col-md-4">
                    <label class="form-label">ABN</label>
                    <input type="text" name="abn" class="form-control" value="{{ old('abn', $company->abn) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">REC / License Number</label>
                    <input type="text" name="rec_number" class="form-control" value="{{ old('rec_number', $company->rec_number) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Insurance / Membership Line</label>
                    <input type="text" name="insurance_line" class="form-control" value="{{ old('insurance_line', $company->insurance_line) }}" placeholder="Insured for $20M public liability (NECA member).">
                </div>
            </div>
            <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $company->address) }}" placeholder="Officer, VIC 3809">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Service Area</label>
                    <input type="text" name="service_area" class="form-control" value="{{ old('service_area', $company->service_area) }}" placeholder="Suburbs/region this business services">
                </div>
            </div>
            <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $company->email) }}">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $company->phone) }}">
                </div>
            </div>
        </div>
    </div>

    <div class="panel mb-4">
        <div class="panel-header">
            <h5><i class="fas fa-university me-2"></i> Payment Details</h5>
        </div>
        <div class="p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Bank Name</label>
                    <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name', $company->bank_name) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Account Name</label>
                    <input type="text" name="bank_account_name" class="form-control" value="{{ old('bank_account_name', $company->bank_account_name) }}">
                </div>
            </div>
            <div class="row g-3 mt-1">
                <div class="col-md-4">
                    <label class="form-label">BSB</label>
                    <input type="text" name="bank_bsb" class="form-control" value="{{ old('bank_bsb', $company->bank_bsb) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Account Number</label>
                    <input type="text" name="bank_account_number" class="form-control" value="{{ old('bank_account_number', $company->bank_account_number) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Payment Reference Note</label>
                    <input type="text" name="payment_reference_note" class="form-control" value="{{ old('payment_reference_note', $company->payment_reference_note) }}" placeholder="USE QUOTE NUMBER AS A REFERENCE.">
                </div>
            </div>
        </div>
    </div>

    <div class="panel mb-4">
        <div class="panel-header">
            <h5><i class="fas fa-image me-2"></i> Branding</h5>
        </div>
        <div class="p-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Logo Path</label>
                    <input type="text" name="logo_path" class="form-control" value="{{ old('logo_path', $company->logo_path) }}" placeholder="images/logo/logo.png">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Dark Logo Path</label>
                    <input type="text" name="logo_dark_path" class="form-control" value="{{ old('logo_dark_path', $company->logo_dark_path) }}" placeholder="images/logo/logo_dark.png">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Favicon Path</label>
                    <input type="text" name="favicon_path" class="form-control" value="{{ old('favicon_path', $company->favicon_path) }}" placeholder="images/logo/favicon-32x32.png">
                </div>
            </div>
            <small class="text-muted d-block mt-2">
                <i class="fas fa-info-circle"></i>
                Paths are relative to the <code>public/</code> folder. Upload the actual image files to that path on the server first, then point these fields at them.
            </small>
        </div>
    </div>

    <div class="text-center mb-5">
        <button type="submit" class="btn btn-gold btn-lg">
            <i class="fas fa-save"></i> Save Company Profile
        </button>
        <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary btn-lg">Cancel</a>
    </div>
</form>

@endsection
