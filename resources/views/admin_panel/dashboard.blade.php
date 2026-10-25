@extends('layouts.app')

@section('title', 'Dashboard')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1 class="dashboard-title">Dashboard</h1>
    </div>

    <a href="{{ route('quote.create') }}" class="btn btn-gold btn-sm">
        <i class="fas fa-plus"></i>
        Create Quote
    </a>
</div>
@endsection

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
                {{-- Rendered by a React component (resources/js/components/RecentQuotes.jsx) --}}
                <script type="application/json" id="recent-quotes-data">
                    {!! $recentQuotes->map(fn($quote) => [
                        'id' => $quote->id,
                        'quote_number' => $quote->quote_number,
                        'customer_name' => $quote->customer_name,
                        'quote_date' => \Carbon\Carbon::parse($quote->quote_date)->format('d/m/Y'),
                        'total' => $quote->total ?? 0,
                        'show_url' => route('quote.show', $quote->id),
                        'pdf_url' => route('quote.pdf', $quote->id),
                        'invoice_pdf_url' => $quote->invoiceCopy ? route('quote.pdf', $quote->invoiceCopy->id) : null,
                    ])->toJson() !!}
                </script>
                <div id="recent-quotes-root"></div>
            </div>

            @push('scripts')
                @vite('resources/js/dashboard-react.jsx')
            @endpush

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