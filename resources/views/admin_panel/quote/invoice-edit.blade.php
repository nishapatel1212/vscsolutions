@extends('layouts.app')

@section('title', 'Edit Invoice - ' . $quote->quote_number)

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
    <h1 class="mb-0 page-title" style="font-size: 22px;">
        Edit Invoice {{ $quote->quote_number }}
    </h1>

    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('quote.index') }}" class="btn-icon-round btn-icon-gray" title="Back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <a href="{{ route('quote.showInvoice', $quote->id) }}" class="btn-icon-round btn-icon-gray" title="View Invoice">
            <i class="fas fa-eye"></i>
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
    .quote-container {
        background: #ffffff;
        padding: 50px;
        width: 100%;
        margin: 0 auto;
        border: 1px solid #e6e8ef;
    }

    .company-logo {
        width: 56px;
        height: 56px;
        object-fit: contain;
    }

    .company-name {
        font-size: 18px;
        font-weight: 700;
        color: var(--latin-navy-deep);
    }

    .company-details {
        color: #4b5160;
        line-height: 1.6;
        font-size: 13px;
    }

    .quote-divider {
        border: 0;
        border-top: 1px solid #e6e8ef;
        margin: 28px 0;
    }

    .section-label {
        color: #6b7280;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 8px;
        text-transform: uppercase;
    }

    .doc-input {
        border: 1px solid transparent;
        border-radius: 6px;
        padding: 4px 8px;
        font-size: 14px;
        width: 100%;
        background: transparent;
        transition: all 0.15s ease;
    }

    .doc-input:hover,
    .doc-input:focus {
        border-color: var(--border-soft);
        background: var(--page-bg);
        outline: none;
    }

    .doc-input.bold {
        font-weight: 700;
        color: var(--latin-navy-deep);
    }

    .items-table th {
        color: #6b7280;
        border: none;
        border-bottom: 2px solid var(--latin-navy-deep);
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 10px 8px;
    }

    .items-table td {
        padding: 8px;
        border-color: #eef0f5;
        vertical-align: top;
    }

    .item-total-display {
        font-weight: 700;
        color: var(--latin-navy-deep);
        padding: 4px 8px;
    }

    .remove-item-btn {
        width: 30px;
        height: 30px;
        border-radius: 6px;
        border: 1px solid var(--border-soft);
        background: #fff;
        color: var(--danger);
    }

    .add-item-btn {
        background: var(--latin-tint);
        color: var(--latin-navy);
        border: none;
        border-radius: 7px;
        font-weight: 600;
        font-size: 13px;
        padding: 8px 14px;
    }

    .totals-table td {
        border: none;
        padding: 6px 8px;
        font-size: 14px;
    }

    .grand-total-input {
        font-size: 18px;
        font-weight: 800;
        color: var(--latin-navy-deep);
        text-align: right;
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

<form action="{{ route('quote.updateInvoice', $quote->id) }}" method="POST" id="invoiceForm">
    @csrf
    @method('PUT')

    <div class="quote-container">

        {{-- HEADER --}}
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('images/logo/latin_logo_dark.png') }}" alt="Latin Electrical" class="company-logo me-3">
                </div>
            </div>

            <div class="col-md-6 text-md-end">
                <div class="company-name">Latin Electrical</div>
                <div class="company-details">
                    Officer, VIC 3809<br>
                    info@latinelectrical.com.au<br>
                    ABN 84 786 819 42<br>
                    REC: 37241
                </div>
            </div>
        </div>

        <hr class="quote-divider">

        {{-- CUSTOMER + INVOICE DETAILS --}}
        <div class="row mb-4">
            <div class="col-md-7">
                <div class="section-label">Invoice To</div>
                <input type="text" name="customer_name" class="doc-input bold" value="{{ old('customer_name', $quote->customer_name) }}" required>
                <textarea name="customer_address" class="doc-input" rows="2" placeholder="Address">{{ old('customer_address', $quote->customer_address) }}</textarea>
                <input type="text" name="customer_phone" class="doc-input" value="{{ old('customer_phone', $quote->customer_phone) }}" placeholder="Phone">
                <input type="email" name="customer_email" class="doc-input" value="{{ old('customer_email', $quote->customer_email) }}" placeholder="Email">
            </div>

            <div class="col-md-5 mt-4 mt-md-0 text-md-end">
                <div class="section-label">Invoice No.</div>
                <div class="doc-input bold" style="display:inline-block;">{{ $quote->quote_number }}</div>

                <div class="section-label mt-2">Date</div>
                <input type="date" name="quote_date" class="doc-input bold" value="{{ old('quote_date', $quote->quote_date) }}" required>
            </div>
        </div>

        {{-- ITEMS --}}
        <table class="table items-table" id="itemsTable">
            <thead>
                <tr>
                    <th style="width:46%;">Activity Description</th>
                    <th style="width:12%;" class="text-center">Qty</th>
                    <th style="width:18%;" class="text-end">Amount</th>
                    <th style="width:18%;" class="text-end">Total</th>
                    <th style="width:6%;"></th>
                </tr>
            </thead>
            <tbody id="itemsBody">
                @foreach($quote->items as $item)
                    <tr class="item-row">
                        <td><textarea name="description[]" class="doc-input" rows="2" required>{{ $item->description }}</textarea></td>
                        <td><input type="number" name="quantity[]" class="doc-input quantity text-center" value="{{ $item->quantity }}" min="1" required></td>
                        <td><input type="number" name="amount[]" class="doc-input amount text-end" value="{{ $item->amount }}" step="0.01" min="0" required></td>
                        <td><div class="item-total-display text-end">${{ number_format($item->total ?? ($item->amount * $item->quantity), 2) }}</div></td>
                        <td class="text-center">
                            <button type="button" class="remove-item-btn remove-item"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="button" class="add-item-btn" id="addItem">
            <i class="fas fa-plus me-1"></i> Add Item
        </button>

        {{-- TOTALS --}}
        <div class="row justify-content-end mt-4">
            <div class="col-md-5">
                <table class="table totals-table">
                    <tr>
                        <td>Subtotal</td>
                        <td class="text-end" id="subtotalDisplay">$0.00</td>
                    </tr>
                    <tr>
                        <td>GST</td>
                        <td class="text-end">$0.00</td>
                    </tr>
                    <tr>
                        <td><strong>Total</strong></td>
                        <td class="grand-total-input" id="grandTotalDisplay">$0.00</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- NOTES --}}
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="section-label">Notes</div>
                <textarea name="notes" class="doc-input" rows="4">{{ old('notes', $quote->notes) }}</textarea>
            </div>
        </div>

    </div>

    <div class="text-center my-4">
        <button type="submit" class="btn btn-gold btn-lg">
            <i class="fas fa-save"></i> Save Invoice
        </button>
        <a href="{{ route('quote.index') }}" class="btn btn-outline-secondary btn-lg">Cancel</a>
    </div>

</form>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function () {

    function recalc() {
        let subtotal = 0;

        $('.item-row').each(function () {
            let qty = parseFloat($(this).find('.quantity').val()) || 0;
            let amt = parseFloat($(this).find('.amount').val()) || 0;
            let total = qty * amt;

            $(this).find('.item-total-display').text('$' + total.toFixed(2));
            subtotal += total;
        });

        $('#subtotalDisplay').text('$' + subtotal.toFixed(2));
        $('#grandTotalDisplay').text('$' + subtotal.toFixed(2));
    }

    $('#addItem').on('click', function () {
        let row = `
            <tr class="item-row">
                <td><textarea name="description[]" class="doc-input" rows="2" required></textarea></td>
                <td><input type="number" name="quantity[]" class="doc-input quantity text-center" value="1" min="1" required></td>
                <td><input type="number" name="amount[]" class="doc-input amount text-end" value="0" step="0.01" min="0" required></td>
                <td><div class="item-total-display text-end">$0.00</div></td>
                <td class="text-center"><button type="button" class="remove-item-btn remove-item"><i class="fas fa-trash"></i></button></td>
            </tr>`;
        $('#itemsBody').append(row);
        recalc();
    });

    $(document).on('click', '.remove-item', function () {
        if ($('.item-row').length > 1) {
            $(this).closest('.item-row').remove();
            recalc();
        } else {
            alert('At least one item is required.');
        }
    });

    $(document).on('input', '.quantity, .amount', recalc);

    recalc();
});
</script>
@endpush