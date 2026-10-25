@extends('layouts.app')

@section('title', 'Quotes')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h1 class="page-title">Quotes</h1>
    </div>

    <a href="{{ route('quote.create') }}" class="btn btn-gold btn-sm">
        <i class="fas fa-plus"></i>
        Create Quote
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

@if(session('error'))
    <div class="alert-soft alert-danger mb-3">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
    </div>
@endif

<div class="panel">

    <div class="panel-header">
        <h5><i class="fas fa-file-invoice me-2"></i> All Quotes</h5>
    </div>

    <div class="table-responsive">
        <table class="table data-table mb-0" id="quoteTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Quote No.</th>
                    <th>Date</th>
                    <th>Client Name</th>
                    <th>Address</th>
                    <th>Total</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($quotes as $index => $quote)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td><span class="quote-number">{{ $quote->quote_number }}</span></td>

                        <td>
                            @if($quote->quote_date)
                                {{ \Carbon\Carbon::parse($quote->quote_date)->format('d/m/Y') }}
                            @endif
                        </td>

                        <td>{{ $quote->customer_name }}</td>

                        <td>{{ $quote->address }}</td>

                        <td>
                            @if(isset($quote->amount_from) && isset($quote->amount_to) && $quote->amount_from != $quote->amount_to)
                                <span class="total-amount">
                                    AUD ${{ number_format($quote->amount_from, 2) }} – ${{ number_format($quote->amount_to, 2) }}
                                </span>
                            @else
                                <span class="total-amount">
                                    AUD ${{ number_format($quote->total ?? 0, 2) }}
                                </span>
                            @endif
                        </td>

                        <td class="text-end">
                            <a href="{{ route('quote.show', $quote->id) }}" class="btn-icon" title="View Quote">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('quote.edit', $quote->id) }}" class="btn-icon btn-icon-edit" title="Edit Quote">
                                <i class="fas fa-edit"></i>
                            </a>

                            <a href="{{ route('quote.pdf', $quote->id) }}" class="btn-icon btn-icon-pdf" title="Download PDF">
                                <i class="fas fa-file-pdf"></i>
                            </a>

                            @if($quote->type === 'invoice')
                                {{-- This row IS an invoice already — no invoice-creation controls --}}
                            @elseif($quote->invoiceCopy)
                                <a href="{{ route('quote.showInvoice', $quote->invoiceCopy->id) }}" class="btn-icon btn-icon-view-invoice" title="View Invoice">
                                    <i class="fas fa-file-invoice"></i>
                                </a>
                            @else
                                <a href="{{ route('quote.makeInvoice', $quote->id) }}" class="btn-icon btn-icon-invoice" title="Create Invoice">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fas fa-file-invoice"></i>
                                No quotes yet — create your first one to get started.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    initDataTable('#quoteTable', {
        order: [[0, 'desc']],
        language: {
            search: '',
            searchPlaceholder: 'Search quotes...'
        }
    });
});
</script>
@endpush