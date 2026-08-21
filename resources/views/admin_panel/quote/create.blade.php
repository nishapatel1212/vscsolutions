@extends('layouts.app')

@section('title', 'Create Quote')


@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <h1>
            Create Quote
        </h1>

        <a
            href="{{ route('quote.index') }}"
            class="btn btn-secondary"
        >
            <i class="fas fa-arrow-left"></i>
            Back
        </a>

    </div>

@endsection


@section('css')

<style>

    .quote-card {
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .quote-card .card-header {
        font-weight: 600;
    }

    .quote-table th {
        background: #f8f9fa;
        vertical-align: middle;
    }

    .quote-table td {
        vertical-align: middle;
    }

    .item-total {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .total-box {
        font-weight: 600;
        font-size: 16px;
    }

    .grand-total {
        font-size: 20px;
        font-weight: 700;
    }

    .required {
        color: red;
    }

</style>

@endsection


@section('content')


{{-- Success Message --}}

@if(session('success'))

    <div class="alert alert-success">

        <i class="fas fa-check-circle"></i>

        {{ session('success') }}

    </div>

@endif


{{-- Error Message --}}

@if(session('error'))

    <div class="alert alert-danger">

        <i class="fas fa-exclamation-circle"></i>

        {{ session('error') }}

    </div>

@endif


{{-- Validation Errors --}}

@if($errors->any())

    <div class="alert alert-danger">

        <strong>
            Please fix the following errors:
        </strong>

        <ul class="mb-0 mt-2">

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif



<form
    action="{{ route('quote.store') }}"
    method="POST"
    id="quoteForm"
>

    @csrf


    {{-- ========================================================= --}}
    {{-- QUOTE INFORMATION --}}
    {{-- ========================================================= --}}

    <div class="card card-warning shadow-sm quote-card">

        <div class="card-header text-white">

            <h5 class="mb-0">

                <i class="fas fa-file-invoice"></i>

                Quote Information

            </h5>

        </div>


        <div class="card-body">

            <div class="row">


                {{-- Quote Number --}}

                <div class="col-md-6">

                    <div class="form-group">

                        <label>
                            Quote Number
                        </label>

                        <input
                            type="text"
                            name="quote_number"
                            class="form-control"
                            value="{{ $quoteNumber }}"
                            readonly
                        >

                    </div>

                </div>



                {{-- Quote Date --}}

                <div class="col-md-6">

                    <div class="form-group">

                        <label>

                            Quote Date

                            <span class="required">
                                *
                            </span>

                        </label>


                        <input
                            type="date"
                            name="quote_date"
                            class="form-control @error('quote_date') is-invalid @enderror"
                            value="{{ old('quote_date', now()->format('Y-m-d')) }}"
                            required
                        >


                        @error('quote_date')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>


            </div>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- CUSTOMER INFORMATION --}}
    {{-- ========================================================= --}}

    <div class="card card-warning shadow-sm quote-card">

        <div class="card-header text-white">

            <h5 class="mb-0">

                <i class="fas fa-user"></i>

                Customer Information

            </h5>

        </div>


        <div class="card-body">


            <div class="row">


                {{-- Customer Name --}}

                <div class="col-md-6">

                    <div class="form-group">

                        <label>

                            Customer Name

                            <span class="required">
                                *
                            </span>

                        </label>


                        <input
                            type="text"
                            name="customer_name"
                            class="form-control @error('customer_name') is-invalid @enderror"
                            value="{{ old('customer_name') }}"
                            placeholder="Enter customer name"
                            required
                        >


                        @error('customer_name')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>



                {{-- Customer Email --}}

                <div class="col-md-6">

                    <div class="form-group">

                        <label>
                            Customer Email
                        </label>


                        <input
                            type="email"
                            name="customer_email"
                            class="form-control @error('customer_email') is-invalid @enderror"
                            value="{{ old('customer_email') }}"
                            placeholder="Enter customer email"
                        >


                        @error('customer_email')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>


            </div>



            <div class="row">


                {{-- Customer Phone --}}

                <div class="col-md-6">

                    <div class="form-group">

                        <label>
                            Customer Phone
                        </label>


                        <input
                            type="text"
                            name="customer_phone"
                            class="form-control @error('customer_phone') is-invalid @enderror"
                            value="{{ old('customer_phone') }}"
                            placeholder="Enter customer phone"
                        >


                        @error('customer_phone')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>



                {{-- Customer Address --}}

                <div class="col-md-6">

                    <div class="form-group">

                        <label>
                            Customer Address
                        </label>


                        <textarea
                            name="customer_address"
                            class="form-control @error('customer_address') is-invalid @enderror"
                            rows="3"
                            placeholder="Enter customer address"
                        >{{ old('customer_address') }}</textarea>


                        @error('customer_address')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>


            </div>


        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- QUOTE ITEMS --}}
    {{-- ========================================================= --}}

    <div class="card card-warning shadow-sm quote-card">

        <div class="card-header text-white">

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="mb-0">

                    <i class="fas fa-list"></i>

                    Quote Items

                </h5>


                <button
                    type="button"
                    class="btn btn-success btn-sm"
                    id="addItem"
                >

                    <i class="fas fa-plus"></i>

                    Add Item

                </button>

            </div>

        </div>


        <div class="card-body">


            <div class="table-responsive">

                <table
                    class="table table-bordered quote-table"
                    id="quoteItemsTable"
                >

                    <thead>

                        <tr>

                            <th style="width: 45%;">
                                Description
                            </th>

                            <th style="width: 12%;">
                                Quantity
                            </th>

                            <th style="width: 18%;">
                                Amount
                            </th>

                            <th style="width: 18%;">
                                Total
                            </th>

                            <th style="width: 7%;">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody id="quoteItems">


                        {{-- First Item --}}

                        <tr class="quote-item-row">


                            {{-- Description --}}

                            <td>

                                <textarea
                                    name="description[]"
                                    class="form-control description"
                                    rows="3"
                                    placeholder="Enter activity description"
                                    required
                                >{{ old('description.0') }}</textarea>

                            </td>


                            {{-- Quantity --}}

                            <td>

                                <input
                                    type="number"
                                    name="quantity[]"
                                    class="form-control quantity"
                                    value="{{ old('quantity.0', 1) }}"
                                    min="1"
                                    step="1"
                                    required
                                >

                            </td>


                            {{-- Amount --}}

                            <td>

                                <div class="input-group">

                                    <div class="input-group-prepend">

                                        <span class="input-group-text">
                                            $
                                        </span>

                                    </div>


                                    <input
                                        type="number"
                                        name="amount[]"
                                        class="form-control amount"
                                        value="{{ old('amount.0') }}"
                                        min="0"
                                        step="0.01"
                                        placeholder="0.00"
                                        required
                                    >

                                </div>

                            </td>


                            {{-- Total --}}

                            <td>

                                <div class="input-group">

                                    <div class="input-group-prepend">

                                        <span class="input-group-text">
                                            $
                                        </span>

                                    </div>


                                    <input
                                        type="text"
                                        class="form-control item-total"
                                        value="0.00"
                                        readonly
                                    >

                                </div>

                            </td>


                            {{-- Remove --}}

                            <td class="text-center">

                                <button
                                    type="button"
                                    class="btn btn-danger btn-sm remove-item"
                                    title="Remove Item"
                                >

                                    <i class="fas fa-trash"></i>

                                </button>

                            </td>


                        </tr>


                    </tbody>


                    <tfoot>

                        <tr>

                            <td
                                colspan="3"
                                class="text-right"
                            >

                                <strong>
                                    Subtotal
                                </strong>

                            </td>


                            <td>

                                <div class="input-group">

                                    <div class="input-group-prepend">

                                        <span class="input-group-text">
                                            $
                                        </span>

                                    </div>


                                    <input
                                        type="text"
                                        id="subtotal"
                                        class="form-control total-box"
                                        value="0.00"
                                        readonly
                                    >

                                </div>

                            </td>


                            <td></td>

                        </tr>


                        <tr>

                            <td
                                colspan="3"
                                class="text-right"
                            >

                                <strong>
                                    GST
                                </strong>

                            </td>


                            <td>

                                <div class="input-group">

                                    <div class="input-group-prepend">

                                        <span class="input-group-text">
                                            $
                                        </span>

                                    </div>


                                    <input
                                        type="text"
                                        id="gst"
                                        class="form-control total-box"
                                        value="0.00"
                                        readonly
                                    >

                                </div>

                            </td>


                            <td></td>

                        </tr>


                        <tr>

                            <td
                                colspan="3"
                                class="text-right"
                            >

                                <strong class="grand-total">
                                    TOTAL
                                </strong>

                            </td>


                            <td>

                                <div class="input-group">

                                    <div class="input-group-prepend">

                                        <span class="input-group-text">
                                            $
                                        </span>

                                    </div>


                                    <input
                                        type="text"
                                        id="grandTotal"
                                        class="form-control grand-total"
                                        value="0.00"
                                        readonly
                                    >

                                </div>

                            </td>


                            <td></td>

                        </tr>

                    </tfoot>

                </table>

            </div>


            <small class="text-muted">

                <i class="fas fa-info-circle"></i>

                Total is automatically calculated as
                Quantity × Amount.

            </small>


        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- PAYMENT / NOTES --}}
    {{-- ========================================================= --}}

    <div class="card card-warning shadow-sm quote-card">

        <div class="card-header text-white">

            <h5 class="mb-0">

                <i class="fas fa-university"></i>

                Payment Methods & Notes

            </h5>

        </div>


        <div class="card-body">


            <div class="row">


                {{-- Payment Details --}}

                <div class="col-md-6">

                    <h5>
                        <strong>
                            Payment Methods
                        </strong>
                    </h5>


                    <p class="mb-1">
                        <strong>
                            Commonwealth Bank
                        </strong>
                    </p>


                    <p class="mb-1">
                        Name: Jasmeen Patel
                    </p>


                    <p class="mb-1">
                        BSB: 063619
                    </p>


                    <p class="mb-1">
                        Account: 11406566
                    </p>


                    <p class="mt-3">

                        <strong>
                            USE Quote NUMBER AS A REFERENCE.
                        </strong>

                    </p>

                </div>



                {{-- Notes --}}

                <div class="col-md-6">

                    <div class="form-group">

                        <label>
                            Notes
                        </label>


                        <textarea
                            name="notes"
                            class="form-control"
                            rows="6"
                            placeholder="Enter any additional notes..."
                        >{{ old('notes') }}</textarea>

                    </div>

                </div>


            </div>


        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- BUTTONS --}}
    {{-- ========================================================= --}}

    <div class="text-center mb-5">

        <button
            type="submit"
            class="btn btn-primary btn-lg mr-2"
        >

            <i class="fas fa-save"></i>

            Save Quote

        </button>


        <a
            href="{{ route('quote.index') }}"
            class="btn btn-secondary btn-lg"
        >

            <i class="fas fa-times"></i>

            Cancel

        </a>

    </div>


</form>

@endsection



@section('js')

<script>

$(document).ready(function () {


    /*
     * Calculate all totals
     */

    function calculateTotals()
    {

        let subtotal = 0;


        $('#quoteItems .quote-item-row').each(function () {


            let quantity = parseFloat(
                $(this).find('.quantity').val()
            ) || 0;


            let amount = parseFloat(
                $(this).find('.amount').val()
            ) || 0;


            let itemTotal = quantity * amount;


            /*
             * Display item total
             */

            $(this)
                .find('.item-total')
                .val(itemTotal.toFixed(2));


            /*
             * Add to subtotal
             */

            subtotal += itemTotal;

        });


        /*
         * GST
         *
         * Currently 0 according to
         * your QuoteController.
         */

        let gst = 0;


        /*
         * Grand Total
         */

        let grandTotal = subtotal + gst;


        /*
         * Update fields
         */

        $('#subtotal')
            .val(subtotal.toFixed(2));


        $('#gst')
            .val(gst.toFixed(2));


        $('#grandTotal')
            .val(grandTotal.toFixed(2));

    }



    /*
     * Add new item
     */

    $('#addItem').on('click', function () {


        let newRow = `

            <tr class="quote-item-row">


                <td>

                    <textarea
                        name="description[]"
                        class="form-control description"
                        rows="3"
                        placeholder="Enter activity description"
                        required
                    ></textarea>

                </td>


                <td>

                    <input
                        type="number"
                        name="quantity[]"
                        class="form-control quantity"
                        value="1"
                        min="1"
                        step="1"
                        required
                    >

                </td>


                <td>

                    <div class="input-group">

                        <div class="input-group-prepend">

                            <span class="input-group-text">
                                $
                            </span>

                        </div>


                        <input
                            type="number"
                            name="amount[]"
                            class="form-control amount"
                            value=""
                            min="0"
                            step="0.01"
                            placeholder="0.00"
                            required
                        >

                    </div>

                </td>


                <td>

                    <div class="input-group">

                        <div class="input-group-prepend">

                            <span class="input-group-text">
                                $
                            </span>

                        </div>


                        <input
                            type="text"
                            class="form-control item-total"
                            value="0.00"
                            readonly
                        >

                    </div>

                </td>


                <td class="text-center">

                    <button
                        type="button"
                        class="btn btn-danger btn-sm remove-item"
                        title="Remove Item"
                    >

                        <i class="fas fa-trash"></i>

                    </button>

                </td>


            </tr>

        `;


        $('#quoteItems').append(newRow);


        calculateTotals();

    });



    /*
     * Remove item
     */

    $(document).on(
        'click',
        '.remove-item',
        function ()
        {

            let rows =
                $('#quoteItems .quote-item-row').length;


            /*
             * Keep at least one row
             */

            if (rows > 1) {

                $(this)
                    .closest('.quote-item-row')
                    .remove();

                calculateTotals();

            } else {

                alert(
                    'At least one quote item is required.'
                );

            }

        }
    );



    /*
     * Recalculate when quantity
     * or amount changes
     */

    $(document).on(
        'input',
        '.quantity, .amount',
        function ()
        {
            calculateTotals();
        }
    );



    /*
     * Initial calculation
     */

    calculateTotals();


});

</script>

@endsection