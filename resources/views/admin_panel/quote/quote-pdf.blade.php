<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Quote {{ $quote->quote_number }}</title>
    <style>

        @page {
            margin: 90px 40px 70px 40px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #222222;
            font-size: 13px;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* =========================================================
           HEADER
        ========================================================= */

        .header-table td {
            vertical-align: top;
            padding: 0;
        }

        .company-logo {
            width: 70%;
            height: 10%;
        }

        .quote-title {
            font-size: 26px;
            font-weight: bold;
            letter-spacing: 3px;
            color: #0F1B47;
            padding-left: 10px;
        }

        .company-name {
            font-size: 16px;
            font-weight: bold;
            color: #0F1B47;
            text-align: right;
        }

        .company-details {
            color: #4b5160;
            font-size: 11px;
            line-height: 1.6;
            text-align: right;
        }

        .rec-number {
            color: #4b5160;
            font-weight: bold;
        }

        .divider {
            border-top: 1px solid #d4d7e0;
            margin: 18px 0;
            height: 1px;
            font-size: 0;
        }

        /* =========================================================
           QUOTE TO / DETAILS
        ========================================================= */

        .section-label {
            color: #6b7280;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .customer-name {
            font-size: 14px;
            font-weight: bold;
            color: #0F1B47;
            padding-top: 4px;
        }

        .customer-details {
            line-height: 1.6;
            color: #2b2b2b;
            font-size: 12px;
            padding-top: 4px;
        }

        .quote-info-label {
            color: #6b7280;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
        }

        .quote-info-value {
            font-weight: bold;
            font-size: 13px;
            color: #0F1B47;
            padding-top: 2px;
            padding-bottom: 8px;
        }

        /* =========================================================
           ITEMS TABLE
        ========================================================= */

        .items-table {
            margin-top: 15px;
        }

        .items-table thead th {
            color: #4b5160;
            border-bottom: 2px solid #0F1B47;
            font-size: 10px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-weight: bold;
            padding: 8px 6px;
            text-align: left;
        }

        .items-table tbody td {
            padding: 10px 6px;
            border-bottom: 1px solid #e2e4ec;
            font-size: 12px;
            vertical-align: top;
            color: #2b2b2b;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* =========================================================
           TOTALS
        ========================================================= */

        .totals-table {
            width: 45%;
            margin-left: 55%;
            margin-top: 10px;
        }

        .totals-table td {
            padding: 5px 6px;
            font-size: 12px;
            color: #4b5160;
        }

        .totals-table .grand-total-row td {
            border-top: 2px solid #0F1B47;
            padding-top: 10px;
            font-size: 15px;
            font-weight: bold;
            color: #0F1B47;
        }

        /* =========================================================
           PAYMENT / NOTES
        ========================================================= */

        .info-table {
            margin-top: 20px;
        }

        .info-table td {
            vertical-align: top;
            width: 50%;
            padding-right: 20px;
        }

        .info-block-title {
            color: #0F1B47;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-top: 1px solid #d4d7e0;
            padding-top: 10px;
        }

        .info-block-body {
            font-size: 12px;
            color: #2b2b2b;
            line-height: 1.6;
            padding-top: 6px;
        }

        .payment-reference {
            color: #0F1B47;
            font-weight: bold;
            font-size: 11px;
            padding-top: 6px;
        }

        /* =========================================================
           FOOTER
        ========================================================= */

        .footer {
            position: fixed;
            bottom: -50px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 11px;
            color: #0F1B47;
            font-weight: bold;
            border-top: 1px solid #d4d7e0;
            padding-top: 10px;
        }

        .footer-small {
            font-size: 9px;
            color: #6b7280;
            font-weight: normal;
            padding-top: 3px;
        }

    </style>
</head>
<body>

    {{-- HEADER --}}
    <table class="header-table">
        <tr>
            <td style="width: 50%;">
                <table>
                    <tr>
                        <td style="width: 60px;">
                            <img src="{{ public_path('images/logo/latin_logo_dark.png') }}" class="company-logo">
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%;">
                <div class="company-name">Latin Electrical</div>
                <div class="company-details">
                    Officer, VIC 3809<br>
                    info@latinelectrical.com.au<br>
                    ABN 84 786 819 42<br>
                    <span class="rec-number">REC: 37241</span>
                </div>
            </td>
        </tr>
    </table>

    <div class="divider">&nbsp;</div>

    {{-- CUSTOMER + QUOTE DETAILS --}}
    <table>
        <tr>
            <td style="width: 58%; vertical-align: top;">
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
            </td>
            <td style="width: 42%; vertical-align: top; text-align: right;">
                <div class="quote-info-label">Quote No.</div>
                <div class="quote-info-value">{{ $quote->quote_number }}</div>

                <div class="quote-info-label">Date</div>
                <div class="quote-info-value">{{ \Carbon\Carbon::parse($quote->quote_date)->format('d/m/Y') }}</div>
            </td>
        </tr>
    </table>

    {{-- ITEMS --}}
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 68%;">Activity Description</th>
                <th style="width: 10%;" class="text-center">Qty</th>
                <th style="width: 12%;" class="text-right">Amount</th>
                <th style="width: 10%;" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quote->items as $item)
                <tr>
                    <td>{!! nl2br(e($item->description)) !!}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">${{ number_format($item->amount ?? 0, 2) }}</td>
                    <td class="text-right">${{ number_format($item->total ?? (($item->amount ?? 0) * $item->quantity), 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TOTALS --}}
    <table class="totals-table">
        <tr>
            <td>Subtotal</td>
            <td class="text-right">${{ number_format($quote->subtotal ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td>GST</td>
            <td class="text-right">${{ number_format($quote->tax ?? 0, 2) }}</td>
        </tr>
        <tr class="grand-total-row">
            <td>Total</td>
            <td class="text-right">AUD ${{ number_format($quote->total ?? 0, 2) }}</td>
        </tr>
    </table>

    {{-- PAYMENT / NOTES --}}
    <table class="info-table">
        <tr>
            <td>
                <div class="info-block-title">Payment Methods</div>
                <div class="info-block-body">
                    <strong>Commonwealth Bank</strong><br>
                    Name: Jasmeen Patel<br>
                    BSB: 063619<br>
                    Account: 11406566
                </div>
                <div class="payment-reference">Use quote number as a reference.</div>
            </td>

            @if(!empty($quote->notes))
                <td>
                    <div class="info-block-title">Notes</div>
                    <div class="info-block-body">{!! nl2br(e($quote->notes)) !!}</div>
                </td>
            @else
                <td></td>
            @endif
        </tr>
    </table>

    <div class="footer">
        Thank you for your business!
        <div class="footer-small">
            Latin Electrical &nbsp;|&nbsp; REC: 37241 &nbsp;|&nbsp; info@latinelectrical.com.au
        </div>
    </div>

</body>
</html>