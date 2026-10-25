@extends('layouts.app')

@section('title', 'Quote - ' . $quote->quote_number)

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
    <h1 class="mb-0 page-title" style="font-size: 22px;">
        {{ $quote->type === 'invoice' ? 'Invoice' : 'Quote' }} {{ $quote->quote_number }}
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

        @if($quote->type !== 'invoice')
            <a href="{{ route('jobs.create', ['quote_id' => $quote->id]) }}" class="btn-icon-round btn-icon-gold" title="Schedule Job">
                <i class="fas fa-calendar-check"></i>
            </a>
        @endif
    </div>
</div>
@endsection

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
                    <div class="quote-info-label">{{ $quote->type === 'invoice' ? 'Invoice No.' : 'Quote No.' }}</div>
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