@extends('layouts.app')

@section('title', 'Quote - ' . $quote->quote_number)


@section('content_header')

<div class="d-flex justify-content-between align-items-center">

    <h1 class="mb-0">
        Quote {{ $quote->quote_number }}
    </h1>

    <div>

        <a
            href="{{ route('quote.index') }}"
            class="btn btn-secondary"
        >
            <i class="fas fa-arrow-left"></i>
            Back
        </a>

        <a
            href="{{ route('quote.edit', $quote->id) }}"
            class="btn btn-warning"
        >
            <i class="fas fa-edit"></i>
            Edit
        </a>

        <button
            type="button"
            onclick="window.print()"
            class="btn btn-primary"
        >
            <i class="fas fa-print"></i>
            Print
        </button>

    </div>

</div>

@endsection


@section('css')

<style>

    :root {
        --latin-navy: #1B2B6B;
        --latin-gold: #F5A623;
        --light-navy: #eef1fb;
        --light-gold: #fff6e5;
    }


    /* =========================================================
       MAIN QUOTE
    ========================================================= */

    .quote-container {

        background: #ffffff;

        padding: 45px;

        max-width: 1200px;

        margin: 0 50px;

        border-top: 7px solid var(--latin-navy);

    }


    /* =========================================================
       LOGO
    ========================================================= */

    .company-logo {

        width: 85px;

        height: 85px;

        object-fit: contain;

        display: block;

    }


    .logo-circle {

        width: 85px;

        height: 85px;

        background: var(--latin-navy);

        border-radius: 50%;

        display: flex;

        align-items: center;

        justify-content: center;

        overflow: hidden;

        border: 4px solid var(--latin-gold);

    }


    .logo-circle img {

        width: 100%;

        height: 100%;

        object-fit: contain;

    }


    /* =========================================================
       COMPANY INFORMATION
    ========================================================= */

    .company-name {

        font-size: 27px;

        font-weight: 800;

        color: var(--latin-navy);

        letter-spacing: 0.5px;

    }


    .company-details {

        color: #444;

        line-height: 1.6;

        font-size: 14px;

    }


    .rec-number {

        color: var(--latin-gold);

        font-weight: 700;

    }


    /* =========================================================
       QUOTE TITLE
    ========================================================= */

    .quote-title {

        font-size: 42px;

        font-weight: 800;

        letter-spacing: 5px;

        color: var(--latin-navy);

        line-height: 1;

    }


    .quote-title-line {

        width: 75px;

        height: 5px;

        background: var(--latin-gold);

        margin-top: 12px;

    }


    /* =========================================================
       DIVIDER
    ========================================================= */

    .gold-divider {

        border: 0;

        border-top: 3px solid var(--latin-gold);

        margin: 25px 0;

    }


    /* =========================================================
       CUSTOMER / QUOTE INFORMATION
    ========================================================= */

    .section-label {

        color: var(--latin-navy);

        font-size: 13px;

        font-weight: 800;

        letter-spacing: 1px;

        margin-bottom: 8px;

    }


    .customer-name {

        font-size: 18px;

        font-weight: 700;

        color: var(--latin-navy);

    }


    .customer-details {

        line-height: 1.7;

        color: #444;

    }


    .quote-info {

        border-left: 4px solid var(--latin-gold);

        padding-left: 18px;

    }


    .quote-info-row {

        margin-bottom: 8px;

    }


    .quote-info-label {

        color: var(--latin-navy);

        font-weight: 700;

        display: inline-block;

        min-width: 85px;

    }


    /* =========================================================
       ITEMS TABLE
    ========================================================= */

    .quote-table {

        margin-top: 25px;

        border: 1px solid #d9dce8;

    }


    .quote-table thead th {

        background: var(--latin-navy);

        color: #ffffff;

        border-color: var(--latin-navy);

        font-size: 13px;

        letter-spacing: 0.5px;

        padding: 13px;

        vertical-align: middle;

    }


    .quote-table tbody td {

        padding: 13px;

        vertical-align: middle;

        border-color: #d9dce8;

    }


    .quote-table tbody tr:nth-child(even) {

        background: #f8f9fd;

    }


    .quote-table tbody tr:hover {

        background: var(--light-gold);

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

        font-weight: 600;

    }


    /* =========================================================
       TOTALS
    ========================================================= */

    .totals-table {

        margin-top: 25px;

        border: none;

    }


    .totals-table th {

        color: var(--latin-navy);

        border: none;

        padding: 9px 12px;

    }


    .totals-table td {

        border: none;

        padding: 9px 12px;

    }


    .total-row {

        border-top: 2px solid var(--latin-gold);

    }


    .grand-total {

        font-size: 22px;

        font-weight: 800;

        color: var(--latin-navy);

    }


    .grand-total td {

        background: var(--light-navy);

    }


    /* =========================================================
       PAYMENT
    ========================================================= */

    .payment-box {

        background: var(--light-navy);

        border-left: 5px solid var(--latin-gold);

        padding: 20px;

        margin-top: 25px;

    }


    .payment-title {

        color: var(--latin-navy);

        font-weight: 800;

        font-size: 17px;

        margin-bottom: 10px;

    }


    .payment-reference {

        color: var(--latin-navy);

        font-weight: 800;

        margin-top: 12px;

    }


    /* =========================================================
       NOTES
    ========================================================= */

    .notes-box {

        border-left: 5px solid var(--latin-gold);

        padding: 20px;

        background: #fffaf0;

        margin-top: 25px;

    }


    .notes-title {

        color: var(--latin-navy);

        font-weight: 800;

        font-size: 17px;

        margin-bottom: 10px;

    }


    /* =========================================================
       FOOTER
    ========================================================= */

    .quote-footer {

        text-align: center;

        margin-top: 45px;

        padding-top: 20px;

        border-top: 2px solid var(--latin-gold);

        color: var(--latin-navy);

        font-weight: 700;

    }


    .quote-footer-small {

        font-size: 12px;

        color: #777;

        margin-top: 5px;

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

            border-top: 5px solid var(--latin-navy);

        }


        .main-footer,
        .main-header,
        .main-sidebar,
        .content-header {

            display: none !important;

        }


        .quote-table tbody tr:hover {

            background: inherit;

        }


        .btn {

            display: none !important;

        }

    }

</style>

@endsection



@section('content')


<div
    class="card shadow-sm"
    id="printQuote"
>


    <div class="quote-container">


        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <div class="row align-items-center">


            {{-- Logo + Quote --}}

            <div class="col-md-6">


                <div class="d-flex align-items-center">


                    <div class="logo-circle mr-3">

                        <img
                            src="{{ asset('images/logo/latin_logo.jpeg') }}"
                            alt="Latin Electrical Logo"
                            class="company-logo"
                        >

                    </div>


                    <div>

                        <div class="quote-title">
                            QUOTE
                        </div>


                        <div class="quote-title-line"></div>

                    </div>


                </div>


            </div>



            {{-- Company Details --}}

            <div class="col-md-6 text-right">


                <div class="company-name">

                    Latin Electrical

                </div>


                <div class="company-details">

                    17 Daisy Street

                    <br>

                    Officer, VIC 3809

                    <br>

                    info@latinelectrical.com.au

                    <br>

                    ABN 84 786 819 42

                    <br>

                    <span class="rec-number">

                        REC: 37241

                    </span>

                </div>


            </div>


        </div>



        <hr class="gold-divider">



        {{-- =====================================================
             CUSTOMER + QUOTE DETAILS
        ====================================================== --}}

        <div class="row mb-4">


            {{-- Customer --}}

            <div class="col-md-7">


                <div class="section-label">

                    QUOTE TO

                </div>


                <div class="customer-name">

                    {{ $quote->customer_name }}

                </div>


                <div class="customer-details">


                    @if(!empty($quote->customer_address))

                        {!! nl2br(e($quote->customer_address)) !!}

                    @endif


                    @if(!empty($quote->customer_phone))

                        <br>

                        <strong>
                            Phone:
                        </strong>

                        {{ $quote->customer_phone }}

                    @endif


                    @if(!empty($quote->customer_email))

                        <br>

                        <strong>
                            Email:
                        </strong>

                        {{ $quote->customer_email }}

                    @endif


                </div>


            </div>



            {{-- Quote Details --}}

            <div class="col-md-5">


                <div class="quote-info">


                    <div class="quote-info-row">

                        <span class="quote-info-label">
                            QUOTE NO:
                        </span>

                        <strong>
                            {{ $quote->quote_number }}
                        </strong>

                    </div>


                    <div class="quote-info-row">

                        <span class="quote-info-label">
                            DATE:
                        </span>

                        <strong>

                            {{ \Carbon\Carbon::parse(
                                $quote->quote_date
                            )->timezone('Australia/Melbourne')->format('d/m/Y') }}

                        </strong>

                    </div>


                </div>


            </div>


        </div>



        {{-- =====================================================
             QUOTE ITEMS
        ====================================================== --}}

        <table class="table quote-table">


            <thead>

                <tr>

                    <th>
                        ACTIVITY DESCRIPTION
                    </th>

                    <th
                        width="10%"
                        class="text-center"
                    >
                        QTY
                    </th>

                    <th
                        width="18%"
                        class="text-right"
                    >
                        AMOUNT
                    </th>

                    <th
                        width="18%"
                        class="text-right"
                    >
                        TOTAL
                    </th>

                </tr>

            </thead>


            <tbody>


                @foreach($quote->items as $item)


                    <tr>


                        <td class="description-cell">

                            {!! nl2br(e($item->description)) !!}

                        </td>


                        <td class="quantity-cell">

                            {{ $item->quantity }}

                        </td>


                        <td class="amount-cell">

                            ${{ number_format(
                                $item->amount ?? 0,
                                2
                            ) }}

                        </td>


                        <td class="total-cell">

                            ${{ number_format(
                                $item->total ?? (
                                    ($item->amount ?? 0)
                                    * $item->quantity
                                ),
                                2
                            ) }}

                        </td>


                    </tr>


                @endforeach


            </tbody>


        </table>



        {{-- =====================================================
             TOTALS
        ====================================================== --}}

        <div class="row justify-content-end">


            <div class="col-md-5">


                <table class="table totals-table">


                    <tr>

                        <th>
                            SUBTOTAL
                        </th>

                        <td class="text-right">

                            ${{ number_format(
                                $quote->subtotal ?? 0,
                                2
                            ) }}

                        </td>

                    </tr>


                    <tr>

                        <th>
                            GST
                        </th>

                        <td class="text-right">

                            ${{ number_format(
                                $quote->tax ?? 0,
                                2
                            ) }}

                        </td>

                    </tr>


                    <tr class="total-row">


                        <th>
                            TOTAL
                        </th>


                        <td class="text-right grand-total">

                            AUD ${{ number_format(
                                $quote->total ?? 0,
                                2
                            ) }}

                        </td>


                    </tr>


                </table>


            </div>


        </div>



        {{-- =====================================================
             PAYMENT + NOTES
        ====================================================== --}}

        <div class="row">


            {{-- Payment --}}

            <div class="col-md-6">


                <div class="payment-box">


                    <div class="payment-title">

                        <i class="fas fa-university"></i>

                        Payment Methods

                    </div>


                    <div>

                        <strong>
                            Commonwealth Bank
                        </strong>

                        <br>

                        Name: Jasmeen Patel

                        <br>

                        BSB: 063619

                        <br>

                        Account: 11406566

                    </div>


                    <div class="payment-reference">

                        USE QUOTE NUMBER AS A REFERENCE.

                    </div>


                </div>


            </div>



            {{-- Notes --}}

            @if(!empty($quote->notes))


                <div class="col-md-6">


                    <div class="notes-box">


                        <div class="notes-title">

                            <i class="fas fa-sticky-note"></i>

                            Notes

                        </div>


                        <div>

                            {!! nl2br(e($quote->notes)) !!}

                        </div>


                    </div>


                </div>


            @endif


        </div>



        {{-- =====================================================
             FOOTER
        ====================================================== --}}

        <div class="quote-footer">


            Thank you for your business!


            <div class="quote-footer-small">

                Latin Electrical
                &nbsp;|&nbsp;
                REC: 37241
                &nbsp;|&nbsp;
                info@latinelectrical.com.au

            </div>


        </div>


    </div>


</div>


@endsection