@extends('layouts.app')

@section('title', 'Quote - ' . $quote->quote_number)

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
    <h1 class="mb-0 page-title" style="font-size: 22px;">
        Quote {{ $quote->quote_number }}
    </h1>

    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('quote.index') }}" class="btn-icon-round btn-icon-gray" title="Back">
            <i class="fas fa-arrow-left"></i>
        </a>

        <a href="{{ route('quote.edit', $quote->id) }}" class="btn-icon-round btn-icon-gold" title="Edit">
            <i class="fas fa-edit"></i>
        </a>

        <a href="{{ route('quote.pdf', $quote->id) }}" class="btn-icon-round btn-icon-red" title="Download PDF">
            <i class="fas fa-file-pdf"></i>
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>

    /* =========================================================
       DOCUMENT SHELL
    ========================================================= */

    .quote-container {
        background: #ffffff;
        padding: 50px;
        width: 70%;
        max-width: 100%;
        margin: 0 auto;
        border: 1px solid #e6e8ef;
    }

    /* =========================================================
       LOGO / TITLE
    ========================================================= */

    .company-logo {
        width: 70%;
        height: 50%;
        object-fit: contain;
        display: block;
    }

    .quote-title {
        font-size: 30px;
        font-weight: 700;
        letter-spacing: 3px;
        color: var(--latin-navy-deep);
        line-height: 1;
    }

    /* =========================================================
       COMPANY INFO
    ========================================================= */

    .company-name {
        font-size: 18px;
        font-weight: 700;
        color: var(--latin-navy-deep);
    }

    .company-details {
        color: #6b7280;
        line-height: 1.6;
        font-size: 13px;
    }

    .rec-number {
        color: #6b7280;
        font-weight: 600;
    }

    /* =========================================================
       DIVIDER
    ========================================================= */

    .quote-divider {
        border: 0;
        border-top: 1px solid #e6e8ef;
        margin: 28px 0;
    }

    /* =========================================================
       QUOTE TO / DETAILS
    ========================================================= */

    .section-label {
        color: #9aa1b5;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 8px;
        text-transform: uppercase;
    }

    .customer-name {
        font-size: 16px;
        font-weight: 700;
        color: var(--latin-navy-deep);
    }

    .customer-details {
        line-height: 1.7;
        color: #444;
        font-size: 14px;
    }

    .quote-info-row {
        margin-bottom: 6px;
        font-size: 14px;
    }

    .quote-info-label {
        color: #9aa1b5;
        font-weight: 600;
        display: inline-block;
        min-width: 85px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* =========================================================
       ITEMS TABLE
    ========================================================= */

    .quote-table {
        margin-top: 8px;
    }

    .quote-table thead th {
        background: none;
        color: #9aa1b5;
        border: none;
        border-bottom: 2px solid var(--latin-navy-deep);
        font-size: 11px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        font-weight: 700;
        padding: 10px 12px;
        vertical-align: middle;
    }

    .quote-table tbody td {
        padding: 14px 12px;
        vertical-align: top;
        border-color: #eef0f5;
        font-size: 14px;
    }

    .description-cell {
        color: #333;
        line-height: 1.6;
    }

    .amount-cell,
    .total-cell {
        text-align: right;
        white-space: nowrap;
    }

    .quantity-cell {
        text-align: center;
    }

    /* =========================================================
       TOTALS
    ========================================================= */

    .totals-table {
        margin-top: 8px;
        border: none;
    }

    .totals-table th {
        color: #6b7280;
        font-weight: 600;
        font-size: 13px;
        border: none;
        padding: 8px 12px;
    }

    .totals-table td {
        border: none;
        padding: 8px 12px;
        font-size: 14px;
    }

    .total-row th,
    .total-row td {
        border-top: 2px solid var(--latin-navy-deep);
        padding-top: 14px;
    }

    .grand-total {
        font-size: 19px;
        font-weight: 700;
        color: var(--latin-navy-deep);
    }

    /* =========================================================
       PAYMENT / NOTES — plain, no fill colors
    ========================================================= */

    .info-block {
        border-top: 1px solid #e6e8ef;
        padding-top: 18px;
        margin-top: 30px;
    }

    .info-block-title {
        color: var(--latin-navy-deep);
        font-weight: 700;
        font-size: 13px;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-block-body {
        font-size: 14px;
        color: #444;
        line-height: 1.7;
    }

    .payment-reference {
        color: var(--latin-navy-deep);
        font-weight: 700;
        margin-top: 10px;
        font-size: 13px;
    }

    /* =========================================================
       FOOTER
    ========================================================= */

    .quote-footer {
        text-align: center;
        margin-top: 40px;
        padding-top: 18px;
        border-top: 1px solid #e6e8ef;
        color: var(--latin-navy-deep);
        font-weight: 600;
        font-size: 14px;
    }

    .quote-footer-small {
        font-size: 11px;
        color: #9aa1b5;
        margin-top: 4px;
        font-weight: 400;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 991px) {
        .quote-container {
            padding: 32px;
        }

        .company-details,
        .company-name {
            text-align: left !important;
        }

        .col-md-6.text-md-end {
            text-align: left !important;
            margin-top: 20px;
        }
    }

    @media (max-width: 767px) {
        .quote-container {
            padding: 22px;
        }

        .quote-title {
            font-size: 24px;
            letter-spacing: 2px;
        }

        .company-name {
            font-size: 16px;
        }

        .company-logo {
            width: 44px;
            height: 44px;
        }

        .quote-table {
            font-size: 13px;
        }
    }

    @media (max-width: 575px) {
        .quote-container {
            padding: 16px;
        }

        .quote-table-wrap {
            overflow-x: auto;
        }

        .quote-table {
            min-width: 460px;
        }
    }

    /* =========================================================
       PRINT
    ========================================================= */

    @media print {
        @page {
            size: A4;
            margin: 12mm;
        }

        body {
            background: #ffffff !important;
        }

        body * {
            visibility: hidden;
        }

        #printQuote,
        #printQuote * {
            visibility: visible;
        }

        #printQuote {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 0;
            box-shadow: none !important;
        }

        .quote-container {
            max-width: none;
            padding: 20px;
            border: none;
        }

        .sidebar,
        .top-navbar,
        .content-header {
            display: none !important;
        }

        .btn {
            display: none !important;
        }
    }

</style>
@endpush

@section('content')

    <div class="quote-container" id="printQuote">

        {{-- HEADER --}}
        <div class="row align-items-center">

            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('images/logo/latin_logo_dark.png') }}" alt="Latin Electrical Logo" class="company-logo me-3">

                    {{-- <div class="quote-title">QUOTE</div> --}}
                </div>
            </div>

            <div class="col-md-6 text-md-end">
                <div class="company-name">Latin Electrical</div>

                <div class="company-details">
                    {{-- 17 Daisy Street<br> --}}
                    Officer, VIC 3809<br>
                    info@latinelectrical.com.au<br>
                    ABN 84 786 819 42<br>
                    <span class="rec-number">REC: 37241</span>
                </div>
            </div>

        </div>

        <hr class="quote-divider">

        {{-- CUSTOMER + QUOTE DETAILS --}}
        <div class="row mb-4">

            <div class="col-md-7">
                <div class="section-label">Quote To</div>

                <div class="customer-name">{{ $quote->customer_name }}</div>

                <div class="customer-details">
                    @if(!empty($quote->customer_address))
                        {!! nl2br(e($quote->customer_address)) !!}
                    @endif

                    @if(!empty($quote->customer_phone))
                        <br><strong>Phone:</strong> {{ $quote->customer_phone }}
                    @endif

                    @if(!empty($quote->customer_email))
                        <br><strong>Email:</strong> {{ $quote->customer_email }}
                    @endif
                </div>
            </div>

            <div class="col-md-5 mt-4 mt-md-0 text-md-end">
                <div class="quote-info-row">
                    <span class="quote-info-label">Quote No.</span><br>
                    <strong>{{ $quote->quote_number }}</strong>
                </div>

                <div class="quote-info-row">
                    <span class="quote-info-label">Date</span><br>
                    <strong>{{ \Carbon\Carbon::parse($quote->quote_date)->format('d/m/Y') }}</strong>
                </div>
            </div>

        </div>

        {{-- QUOTE ITEMS --}}
        <div class="quote-table-wrap">
            <table class="table quote-table">
                <thead>
                    <tr>
                        <th>Activity Description</th>
                        <th width="10%" class="text-center">Qty</th>
                        <th width="18%" class="text-end">Amount</th>
                        <th width="18%" class="text-end">Total</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($quote->items as $item)
                        <tr>
                            <td class="description-cell">{!! nl2br(e($item->description)) !!}</td>
                            <td class="quantity-cell">{{ $item->quantity }}</td>
                            <td class="amount-cell">${{ number_format($item->amount ?? 0, 2) }}</td>
                            <td class="total-cell">${{ number_format($item->total ?? (($item->amount ?? 0) * $item->quantity), 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- TOTALS --}}
        <div class="row justify-content-end">
            <div class="col-md-5">
                <table class="table totals-table">
                    <tr>
                        <th>Subtotal</th>
                        <td class="text-end">${{ number_format($quote->subtotal ?? 0, 2) }}</td>
                    </tr>

                    <tr>
                        <th>GST</th>
                        <td class="text-end">${{ number_format($quote->tax ?? 0, 2) }}</td>
                    </tr>

                    <tr class="total-row">
                        <th>Total</th>
                        <td class="text-end grand-total">AUD ${{ number_format($quote->total ?? 0, 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- PAYMENT + NOTES --}}
        <div class="row">

            <div class="col-md-6">
                <div class="info-block">
                    <div class="info-block-title">
                        <i class="fas fa-university me-1"></i> Payment Methods
                    </div>

                    <div class="info-block-body">
                        <strong>Commonwealth Bank</strong><br>
                        Name: Jasmeen Patel<br>
                        BSB: 063619<br>
                        Account: 11406566
                    </div>

                    <div class="payment-reference">
                        Use quote number as a reference.
                    </div>
                </div>
            </div>

            @if(!empty($quote->notes))
                <div class="col-md-6">
                    <div class="info-block">
                        <div class="info-block-title">
                            <i class="fas fa-sticky-note me-1"></i> Notes
                        </div>

                        <div class="info-block-body">{!! nl2br(e($quote->notes)) !!}</div>
                    </div>
                </div>
            @endif

        </div>

        {{-- FOOTER --}}
        <div class="quote-footer">
            Thank you for your business!

            <div class="quote-footer-small">
                Latin Electrical &nbsp;|&nbsp; REC: 37241 &nbsp;|&nbsp; info@latinelectrical.com.au
            </div>
        </div>

    </div>


@endsection