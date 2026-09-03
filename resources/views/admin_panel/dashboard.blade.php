@extends('layouts.app')

@section('title', 'Dashboard')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1 class="dashboard-title">Dashboard</h1>
        <p class="dashboard-subtitle">Welcome to Latin Electrical</p>
    </div>

    <a href="{{ route('quote.create') }}" class="btn btn-gold btn-sm">
        <i class="fas fa-plus"></i>
        Create Quote
    </a>
</div>
@endsection

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --latin-navy: #1B2B6B;
    --latin-navy-deep: #0F1B47;
    --latin-gold: #F5A623;
    --latin-gold-dark: #E89A13;
    --latin-tint: #EDF0F9;
    --latin-bg: #f5f7fb;
    --latin-text-muted: #7A82A0;
    --font-display: 'Sora', sans-serif;
    --font-body: 'Inter', sans-serif;
}

body {
    background: var(--latin-bg);
    font-family: var(--font-body);
}

.dashboard-title {
    font-family: var(--font-display);
    color: var(--latin-navy-deep);
    font-weight: 700;
    letter-spacing: -0.02em;
    margin-bottom: 3px;
}

.dashboard-subtitle {
    color: var(--latin-text-muted);
    margin-bottom: 0;
    font-size: 14px;
}

.btn-gold {
    background: var(--latin-gold);
    border-color: var(--latin-gold);
    color: var(--latin-navy-deep);
    font-weight: 700;
    font-family: var(--font-body);
    border-radius: 8px;
    padding: 9px 18px;
    box-shadow: 0 4px 12px rgba(245, 166, 35, 0.35);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}

.btn-gold:hover {
    background: var(--latin-gold-dark);
    border-color: var(--latin-gold-dark);
    color: var(--latin-navy-deep);
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(245, 166, 35, 0.45);
}

.dashboard-card {
    position: relative;
    background: #ffffff;
    border-radius: 12px;
    border: none;
    box-shadow: 0 3px 12px rgba(27, 43, 107, 0.07);
    min-height: 135px;
    overflow: hidden;
    transition: box-shadow 0.2s ease, transform 0.2s ease;
}

.dashboard-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: var(--latin-gold);
    transform: scaleY(0);
    transform-origin: bottom;
    transition: transform 0.2s ease;
}

.dashboard-card:hover {
    box-shadow: 0 8px 24px rgba(27, 43, 107, 0.14);
    transform: translateY(-2px);
}

.dashboard-card:hover::before {
    transform: scaleY(1);
}

.dashboard-card .icon {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: linear-gradient(145deg, var(--latin-navy), var(--latin-navy-deep));
    color: var(--latin-gold);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.dashboard-card h3 {
    font-family: var(--font-display);
    color: var(--latin-navy-deep);
    font-size: 26px;
    font-weight: 700;
    margin: 0;
    line-height: 1.2;
}

.dashboard-card p {
    color: var(--latin-text-muted);
    margin: 3px 0 0;
    font-size: 13px;
    font-weight: 500;
}

.dashboard-card.company-id {
    background: linear-gradient(135deg, var(--latin-navy) 0%, var(--latin-navy-deep) 100%);
}

.dashboard-card.company-id .icon {
    background: rgba(245, 166, 35, 0.15);
    color: var(--latin-gold);
}

.dashboard-card.company-id h3 {
    color: #ffffff;
    font-size: 20px;
    letter-spacing: 0.03em;
}

.dashboard-card.company-id p {
    color: rgba(255, 255, 255, 0.65);
}

.dashboard-card.company-id::before {
    background: var(--latin-gold);
}

.dashboard-section {
    background: #ffffff;
    border-radius: 12px;
    border: none;
    box-shadow: 0 3px 12px rgba(27, 43, 107, 0.07);
}

.dashboard-section-header {
    padding: 18px 20px;
    border-bottom: 1px solid var(--latin-tint);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.dashboard-section-header h5 {
    font-family: var(--font-display);
    color: var(--latin-navy-deep);
    font-weight: 700;
    font-size: 16px;
    margin: 0;
}

.dashboard-section-header h5 i {
    color: var(--latin-gold);
}

.dashboard-table thead th {
    background: var(--latin-tint);
    color: var(--latin-navy-deep);
    border: none;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: 700;
    padding: 12px 16px;
}

.dashboard-table td {
    vertical-align: middle;
    padding: 14px 16px;
    font-size: 14px;
    border-color: #f0f2f8;
}

.dashboard-table tbody tr {
    transition: background 0.15s ease;
}

.dashboard-table tbody tr:hover {
    background: var(--latin-bg);
}

.quote-number {
    display: inline-block;
    background: var(--latin-tint);
    color: var(--latin-navy);
    font-weight: 700;
    font-size: 12.5px;
    padding: 4px 10px;
    border-radius: 6px;
}

.dashboard-table .btn-outline-primary {
    color: var(--latin-navy);
    border-color: var(--latin-navy);
    border-radius: 6px;
}

.dashboard-table .btn-outline-primary:hover {
    background: var(--latin-navy);
    border-color: var(--latin-navy);
}

.dashboard-empty {
    padding: 48px 20px;
    text-align: center;
    color: var(--latin-text-muted);
}

.dashboard-empty i {
    font-size: 32px;
    color: var(--latin-tint);
    display: block;
    margin-bottom: 10px;
}

.quick-action {
    display: flex;
    align-items: center;
    padding: 14px 16px;
    border-radius: 8px;
    background: var(--latin-bg);
    color: var(--latin-navy-deep);
    text-decoration: none !important;
    margin-bottom: 10px;
    font-weight: 600;
    font-size: 14px;
    transition: background 0.15s ease, padding-left 0.15s ease;
}

.quick-action:last-child {
    margin-bottom: 0;
}

.quick-action:hover {
    background: #FFF5DF;
    color: var(--latin-navy-deep);
    padding-left: 20px;
}

.quick-action .icon-circle {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: rgba(27, 43, 107, 0.06);
    color: var(--latin-gold);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    flex-shrink: 0;
    font-size: 14px;
}

.quick-action .arrow {
    margin-left: auto;
    opacity: 0;
    transform: translateX(-4px);
    transition: 0.15s ease;
    color: var(--latin-gold);
}

.quick-action:hover .arrow {
    opacity: 1;
    transform: translateX(0);
}
</style>
@endpush

@section('content')

<div class="row">

    <div class="col-lg-3 col-md-6">
        <div class="dashboard-card p-3 mb-4">
            <div class="d-flex align-items-center">
                <div class="icon me-3">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div>
                    <h3>{{ $totalQuotes }}</h3>
                    <p>Total Quotes</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="dashboard-card p-3 mb-4">
            <div class="d-flex align-items-center">
                <div class="icon me-3">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div>
                    <h3>{{ $monthlyQuotes }}</h3>
                    <p>This Month</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="dashboard-card p-3 mb-4">
            <div class="d-flex align-items-center">
                <div class="icon me-3">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div>
                    <h3>${{ number_format($totalQuoteValue ?? 0, 2) }}</h3>
                    <p>Quote Value</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="dashboard-card company-id p-3 mb-4">
            <div class="d-flex align-items-center">
                <div class="icon me-3">
                    <i class="fas fa-bolt"></i>
                </div>
                <div>
                    <h3>REC 37241</h3>
                    <p>Registered Electrical Contractor</p>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">

    <div class="col-lg-8">
        <div class="dashboard-section mb-4">

            <div class="dashboard-section-header">
                <h5><i class="fas fa-file-invoice me-2"></i> Recent Quotes</h5>
                <a href="{{ route('quote.index') }}" class="text-muted" style="font-size:13px; font-weight:600; text-decoration:none;">
                    View all <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover dashboard-table mb-0">
                    <thead>
                        <tr>
                            <th>Quote No.</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th class="text-end">Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentQuotes as $quote)
                            <tr>
                                <td><span class="quote-number">{{ $quote->quote_number }}</span></td>
                                <td>{{ $quote->customer_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($quote->quote_date)->format('d/m/Y') }}</td>
                                <td class="text-end fw-bold">${{ number_format($quote->total ?? 0, 2) }}</td>
                                <td class="text-end">
                                    <a href="{{ route('quote.show', $quote->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="dashboard-empty">
                                        <i class="fas fa-file-invoice"></i>
                                        No quotes yet — create your first one to see it here.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="col-lg-4">
        <div class="dashboard-section mb-4">

            <div class="dashboard-section-header">
                <h5><i class="fas fa-bolt me-2"></i> Quick Actions</h5>
            </div>

            <div class="p-3">
                <a href="{{ route('quote.create') }}" class="quick-action">
                    <span class="icon-circle"><i class="fas fa-plus-circle"></i></span>
                    Create New Quote
                    <i class="fas fa-arrow-right arrow"></i>
                </a>

                <a href="{{ route('quote.index') }}" class="quick-action">
                    <span class="icon-circle"><i class="fas fa-file-invoice"></i></span>
                    View All Quotes
                    <i class="fas fa-arrow-right arrow"></i>
                </a>

                <a href="{{ url('/safety-check-report') }}" class="quick-action">
                    <span class="icon-circle"><i class="fas fa-clipboard-check"></i></span>
                    Safety Check Reports
                    <i class="fas fa-arrow-right arrow"></i>
                </a>
            </div>

        </div>
    </div>

</div>

@endsection