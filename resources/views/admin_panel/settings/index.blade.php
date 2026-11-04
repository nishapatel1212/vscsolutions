@extends('layouts.app')

@section('title', 'Settings')

@section('content_header')
<div>
    <h1 class="page-title">Settings</h1>
    <p class="page-subtitle">Data that used to require editing Python files directly</p>
</div>
@endsection

@section('content')

<div class="row g-4">

    <div class="col-md-6">
        <a href="{{ route('settings.company-profile.edit') }}" class="text-decoration-none">
            <div class="panel h-100">
                <div class="p-4">
                    <div class="d-flex align-items-center mb-2">
                        <div class="icon-circle me-3" style="width:44px;height:44px;border-radius:50%;background:rgba(27,43,107,0.06);color:var(--latin-gold);display:flex;align-items:center;justify-content:center;font-size:18px;">
                            <i class="fas fa-building"></i>
                        </div>
                        <h5 class="mb-0" style="color:var(--latin-navy-deep);">Company Profile</h5>
                    </div>
                    <p class="text-muted mb-1">{{ $company->company_name ?: 'Not set up yet' }}</p>
                    <p class="text-muted mb-0" style="font-size:13px;">Business name, ABN, REC number, bank details, and logo — shown on every quote, invoice, PDF, email, and the chatbot.</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6">
        <a href="{{ route('settings.job-keywords.index') }}" class="text-decoration-none">
            <div class="panel h-100">
                <div class="p-4">
                    <div class="d-flex align-items-center mb-2">
                        <div class="icon-circle me-3" style="width:44px;height:44px;border-radius:50%;background:rgba(27,43,107,0.06);color:var(--latin-gold);display:flex;align-items:center;justify-content:center;font-size:18px;">
                            <i class="fas fa-tags"></i>
                        </div>
                        <h5 class="mb-0" style="color:var(--latin-navy-deep);">Job Type Keywords</h5>
                    </div>
                    <p class="text-muted mb-1">{{ $keywordCount }} keyword(s) configured</p>
                    <p class="text-muted mb-0" style="font-size:13px;">Controls how the chatbot and lead intake auto-classify job descriptions into a job type.</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6">
        <a href="{{ route('settings.price-list.index') }}" class="text-decoration-none">
            <div class="panel h-100">
                <div class="p-4">
                    <div class="d-flex align-items-center mb-2">
                        <div class="icon-circle me-3" style="width:44px;height:44px;border-radius:50%;background:rgba(27,43,107,0.06);color:var(--latin-gold);display:flex;align-items:center;justify-content:center;font-size:18px;">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <h5 class="mb-0" style="color:var(--latin-navy-deep);">Quote Price List</h5>
                    </div>
                    <p class="text-muted mb-1">{{ $priceItemCount }} item(s) configured</p>
                    <p class="text-muted mb-0" style="font-size:13px;">Drives AI quote-drafting ("Generate" on the quote form) and the chatbot's price guide.</p>
                </div>
            </div>
        </a>
    </div>

</div>

@endsection
