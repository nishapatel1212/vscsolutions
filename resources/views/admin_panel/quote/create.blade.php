@extends('layouts.app')

@section('title', 'Create Quote')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h1 class="page-title">Create Quote</h1>
    </div>

    <div class="d-flex flex-wrap gap-2">
        <button type="submit" class="btn btn-gold btn-sm me-2">
            <i class="fas fa-save"></i>
            Save
        </button>

        <a href="{{ route('quote.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i>
        </a>
    </div>
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

    .required {
        color: var(--danger);
    }

    .quote-items-table th {
        background: var(--latin-tint);
        color: var(--latin-navy-deep);
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-weight: 700;
        border: none;
        padding: 12px 14px;
        vertical-align: middle;
    }

    .quote-items-table td {
        vertical-align: middle;
        padding: 12px 14px;
        border-color: var(--border-soft);
    }

    .item-total-input {
        background: var(--latin-tint) !important;
        font-weight: 700;
        color: var(--latin-navy-deep);
    }

    .totals-row td {
        border: none;
        padding: 10px 14px;
    }

    .totals-row.grand td {
        border-top: 2px solid var(--latin-tint);
        padding-top: 16px;
    }

    .grand-total-input {
        font-size: 18px;
        font-weight: 800;
        color: var(--latin-navy-deep);
        background: #fff !important;
    }

    .payment-box {
        background: var(--page-bg);
        border-radius: 10px;
        padding: 18px 20px;
    }

    .payment-box p {
        margin-bottom: 4px;
        font-size: 14px;
    }

    .remove-item-btn {
        width: 34px;
        height: 34px;
        border-radius: 7px;
        border: 1px solid var(--border-soft);
        background: #fff;
        color: var(--danger);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
    }

    .remove-item-btn:hover {
        background: var(--danger);
        color: #fff;
        border-color: var(--danger);
    }

    .add-item-btn {
        background: var(--latin-tint);
        color: var(--latin-navy);
        border: none;
        border-radius: 7px;
        font-weight: 600;
        font-size: 13px;
        padding: 8px 14px;
        transition: all 0.15s ease;
    }

    .add-item-btn:hover {
        background: var(--latin-navy);
        color: #fff;
    }
</style>
@endpush

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


@if($errors->any())
    <div class="alert-soft alert-danger mb-3" style="align-items: flex-start;">
        <i class="fas fa-exclamation-circle mt-1"></i>
        <div>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<form action="{{ route('quote.store') }}" method="POST" id="quoteForm">
    @csrf

    {{-- QUOTE INFORMATION --}}
    <div class="panel mb-4">
        <div class="panel-header">
            <h5><i class="fas fa-file-invoice me-2"></i> Quote Information</h5>
        </div>

        <div class="p-4">
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Quote Number</label>
                    <input type="text" name="quote_number" class="form-control" value="{{ $quoteNumber }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Quote Date <span class="required">*</span></label>
                    <input type="date" name="quote_date"
                           class="form-control @error('quote_date') is-invalid @enderror"
                           value="{{ old('quote_date', now()->format('Y-m-d')) }}" required>
                    @error('quote_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>
    </div>

    {{-- CUSTOMER INFORMATION --}}
    <div class="panel mb-4">
        <div class="panel-header">
            <h5><i class="fas fa-user me-2"></i> Customer Information</h5>
        </div>

        <div class="p-4">
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Customer Name <span class="required">*</span></label>
                    <input type="text" name="customer_name"
                           class="form-control @error('customer_name') is-invalid @enderror"
                           value="{{ old('customer_name') }}" placeholder="Enter customer name" required>
                    @error('customer_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Customer Email</label>
                    <input type="email" name="customer_email"
                           class="form-control @error('customer_email') is-invalid @enderror"
                           value="{{ old('customer_email') }}" placeholder="Enter customer email">
                    @error('customer_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="row g-3 mt-1">

                <div class="col-md-6">
                    <label class="form-label">Customer Phone</label>
                    <input type="text" name="customer_phone"
                           class="form-control @error('customer_phone') is-invalid @enderror"
                           value="{{ old('customer_phone') }}" placeholder="Enter customer phone">
                    @error('customer_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Customer Address</label>
                    <textarea name="customer_address"
                              class="form-control @error('customer_address') is-invalid @enderror"
                              rows="3" placeholder="Enter customer address">{{ old('customer_address') }}</textarea>
                    @error('customer_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>
    </div>

    {{-- QUOTE ITEMS --}}
    <div class="panel mb-4">
        <div class="panel-header">
            <h5><i class="fas fa-list me-2"></i> Quote Items</h5>
            <button type="button" class="add-item-btn" id="addItem">
                <i class="fas fa-plus me-1"></i> Add Item
            </button>
            <button type="button" class="add-item-btn" id="aiGenerate">
                <i class="fas fa-magic me-1"></i> Generate with AI
            </button>
            <input type="text" id="jobDescInput" class="form-control d-none" placeholder="Describe the job...">
        </div>

        <div id="aiAlertContainer"></div>

        <div class="p-4">
            <div class="table-responsive">
                <table class="table quote-items-table" id="quoteItemsTable">
                    <thead>
                        <tr>
                            <th style="width: 45%;">Description</th>
                            <th style="width: 12%;">Quantity</th>
                            <th style="width: 18%;">Amount</th>
                            <th style="width: 18%;">Total</th>
                            <th style="width: 7%;"></th>
                        </tr>
                    </thead>

                    <tbody id="quoteItems">
                        <tr class="quote-item-row">
                            <td>
                                <textarea name="description[]" class="form-control description" rows="3"
                                          placeholder="Enter activity description" required>{{ old('description.0') }}</textarea>
                            </td>
                            <td>
                                <input type="number" name="quantity[]" class="form-control quantity"
                                       value="{{ old('quantity.0', 1) }}" min="1" step="1" required>
                            </td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="amount[]" class="form-control amount"
                                           value="{{ old('amount.0') }}" min="0" step="0.01" placeholder="0.00" required>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control item-total item-total-input" value="0.00" readonly>
                                </div>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-outline-primary check-price-btn" title="Check AI Price">
        <i class="fas fa-magnifying-glass-dollar"></i>
    </button>
                                <button type="button" class="remove-item-btn remove-item" title="Remove Item">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr class="totals-row">
                            <td colspan="3" class="text-end"><strong>Subtotal</strong></td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" id="subtotal" class="form-control" value="0.00" readonly>
                                </div>
                            </td>
                            <td></td>
                        </tr>

                        <tr class="totals-row">
                            <td colspan="3" class="text-end"><strong>GST</strong></td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" id="gst" class="form-control" value="0.00" readonly>
                                </div>
                            </td>
                            <td></td>
                        </tr>

                        <tr class="totals-row grand">
                            <td colspan="3" class="text-end"><strong style="font-size:16px;">TOTAL</strong></td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" id="grandTotal" class="form-control grand-total-input" value="0.00" readonly>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <small class="text-muted">
                <i class="fas fa-info-circle"></i>
                Total is automatically calculated as Quantity × Amount.
            </small>
        </div>
    </div>

    {{-- PAYMENT / NOTES --}}
    <div class="panel mb-4">
        <div class="panel-header">
            <h5><i class="fas fa-university me-2"></i> Payment Methods & Notes</h5>
        </div>

        <div class="p-4">
            <div class="row g-4">

                <div class="col-md-6">
                    <div class="payment-box">
                        <h6 class="fw-bold mb-2">Payment Methods</h6>
                        <p class="fw-bold">Commonwealth Bank</p>
                        <p>Name: Jasmeen Patel</p>
                        <p>BSB: 063619</p>
                        <p>Account: 11406566</p>
                        <p class="mt-3 fw-bold">USE QUOTE NUMBER AS A REFERENCE.</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="6" placeholder="Enter any additional notes...">{{ old('notes') }}</textarea>
                </div>

            </div>
        </div>
    </div>

    {{-- BUTTONS --}}
    <div class="text-center mb-5">
        <button type="submit" class="btn btn-gold btn-sm me-2">
            <i class="fas fa-save"></i>
            Save
        </button>

        <a href="{{ route('quote.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i>
        </a>
    </div>

</form>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$(document).ready(function () {

    $('#aiGenerate').on('click', function () {
        let desc = prompt("Describe the job:");
        if (!desc) return;

        $.post("{{ route('quote.aiDraft') }}", {
            _token: "{{ csrf_token() }}",
            job_description: desc
        }, function (data) {

            if (!data.items || data.items.length === 0) {
                showAiAlert('warning', 'No matching services found for that description. Try different wording or add items manually.');
                return;
            }

            data.items.forEach(function (item) {
                let row = `
                    <tr class="quote-item-row">
                        <td><textarea name="description[]" class="form-control description" rows="3" required>${item.description}</textarea></td>
                        <td><input type="number" name="quantity[]" class="form-control quantity" value="${item.quantity}" min="1" step="1" required></td>
                        <td><div class="input-group"><span class="input-group-text">$</span><input type="number" name="amount[]" class="form-control amount" value="${item.amount}" min="0" step="0.01" required></div></td>
                        <td><div class="input-group"><span class="input-group-text">$</span><input type="text" class="form-control item-total item-total-input" value="0.00" readonly></div></td>
                        <td class="text-center"><button type="button" class="btn btn-sm btn-outline-primary check-price-btn" title="Check AI Price">
                            <i class="fas fa-magnifying-glass-dollar"></i>
                        </button><button type="button" class="remove-item-btn remove-item"><i class="fas fa-trash"></i></button></td>
                    </tr>`;
                $('#quoteItems').append(row);
            });
            calculateTotals();
            showAiAlert('success', `${data.items.length} item(s) added from AI suggestion.`);

        }).fail(function () {
            showAiAlert('danger', 'Something went wrong generating the quote. Please try again.');
        });
    });

    function showAiAlert(type, message) {
        // type: 'success', 'danger', or 'warning'
        const icon = type === 'success' ? 'fa-check-circle'
                : type === 'danger' ? 'fa-exclamation-triangle'
                : 'fa-exclamation-circle';

        const alertHtml = `
            <div class="alert-soft alert-${type} mb-3 ai-alert">
                <i class="fas ${icon}"></i>
                ${message}
            </div>`;

        $('#aiAlertContainer').html(alertHtml);

        // Auto remove after 4 seconds
        setTimeout(function () {
            $('.ai-alert').fadeOut(300, function () { $(this).remove(); });
        }, 4000);
    }

    function calculateTotals() {
        let subtotal = 0;

        $('#quoteItems .quote-item-row').each(function () {
            let quantity = parseFloat($(this).find('.quantity').val()) || 0;
            let amount = parseFloat($(this).find('.amount').val()) || 0;
            let itemTotal = quantity * amount;

            $(this).find('.item-total').val(itemTotal.toFixed(2));
            subtotal += itemTotal;
        });

        let gst = 0;
        let grandTotal = subtotal + gst;

        $('#subtotal').val(subtotal.toFixed(2));
        $('#gst').val(gst.toFixed(2));
        $('#grandTotal').val(grandTotal.toFixed(2));
    }

    $('#addItem').on('click', function () {
        let newRow = `
            <tr class="quote-item-row">
                <td>
                    <textarea name="description[]" class="form-control description" rows="3"
                              placeholder="Enter activity description" required></textarea>
                </td>
                <td>
                    <input type="number" name="quantity[]" class="form-control quantity"
                           value="1" min="1" step="1" required>
                </td>
                <td>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" name="amount[]" class="form-control amount"
                               value="" min="0" step="0.01" placeholder="0.00" required>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control item-total item-total-input" value="0.00" readonly>
                    </div>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-primary check-price-btn" title="Check AI Price">
                        <i class="fas fa-magnifying-glass-dollar"></i>
                    </button>
                    <button type="button" class="remove-item-btn remove-item" title="Remove Item">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;

        $('#quoteItems').append(newRow);
        calculateTotals();
    });

    $(document).on('click', '.remove-item', function () {
        let rows = $('#quoteItems .quote-item-row').length;

        if (rows > 1) {
            $(this).closest('.quote-item-row').remove();
            calculateTotals();
        } else {
            alert('At least one quote item is required.');
        }
    });

    $(document).on('input', '.quantity, .amount', function () {
        calculateTotals();
    });

    $(document).on('click', '.check-price-btn', function () {
        let row = $(this).closest('.quote-item-row');
        let description = row.find('.description').val();
        let quantity = row.find('.quantity').val();
        let amount = row.find('.amount').val();

        if (!description || !quantity || !amount) {
            showAiAlert('warning', 'Fill in description, quantity, and amount before checking the price.');
            return;
        }

        let $btn = $(this);
        $btn.prop('disabled', true).find('i').removeClass('fa-magnifying-glass-dollar').addClass('fa-spinner fa-spin');

        $.post("{{ route('quote.checkPrice') }}", {
            _token: "{{ csrf_token() }}",
            description: description,
            quantity: quantity,
            amount: amount
        }, function (data) {
            if (data.flagged) {
                showAiAlert('warning',
                    `This price looks unusual for "${description}" — expected around $${data.predicted_amount}, you entered $${data.proposed_amount}.`);
            } else if (data.note) {
                showAiAlert('success', data.note);
            } else {
                showAiAlert('success', 'Price looks in line with past quotes.');
            }
        }).fail(function (xhr) {
            console.error('checkPrice failed:', xhr.status, xhr.responseText);
            showAiAlert('danger', 'Price check failed — please try again.');
        }).always(function () {
            $btn.prop('disabled', false).find('i').removeClass('fa-spinner fa-spin').addClass('fa-magnifying-glass-dollar');
        });
    });

    calculateTotals();

});
</script>
@endpush