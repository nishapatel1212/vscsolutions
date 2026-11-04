<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $certificate->certificate_number }}</title>
    <style>
        @page { margin: 30px; }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            color: #333;
            font-size: 12px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 3px solid #e8581c;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header img { height: 45px; }
        .header .company-name { font-size: 16px; font-weight: bold; color: #222; }
        .header .company-meta { font-size: 10px; color: #666; }

        .cert-title {
            text-align: center;
            margin-bottom: 20px;
        }
        .cert-title h1 {
            font-size: 22px;
            margin: 0;
            color: #222;
        }
        .cert-title .cert-number {
            font-size: 13px;
            color: #e8581c;
            font-weight: bold;
            margin-top: 4px;
        }

        .status-pill {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 11px;
            color: #fff;
        }
        .status-pass { background: #1a7f45; }
        .status-fail { background: #c0392b; }

        table.info { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.info td { padding: 6px 8px; border: 1px solid #ddd; vertical-align: top; }
        table.info td.label { width: 32%; font-weight: bold; background: #f7f7f7; }

        h3.section-title {
            font-size: 13px;
            color: #e8581c;
            border-bottom: 1px solid #ddd;
            padding-bottom: 4px;
            margin: 20px 0 10px;
        }

        table.items { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        table.items th, table.items td { border: 1px solid #ddd; padding: 6px 8px; font-size: 11px; text-align: left; }
        table.items th { background: #f0f0f0; }

        .result-pass { color: #1a7f45; font-weight: bold; }
        .result-fail { color: #c0392b; font-weight: bold; }

        .declaration {
            margin-top: 25px;
            font-size: 11px;
            line-height: 1.6;
        }

        .signature-block {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box { width: 45%; }
        .signature-line { border-top: 1px solid #333; margin-top: 35px; padding-top: 4px; font-size: 10px; }

        .footer-note {
            margin-top: 30px;
            font-size: 9px;
            color: #888;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header">
        <div>
            @if(company('logo_dark_path') && file_exists(public_path(company('logo_dark_path'))))
                <img src="{{ public_path(company('logo_dark_path')) }}" alt="{{ company('company_name') }}">
            @endif
            <div class="company-name">{{ company('company_name', 'Latin Electrical') }}</div>
            <div class="company-meta">
                {{ company('address') }}
                @if(company('phone')) · {{ company('phone') }} @endif
                @if(company('email')) · {{ company('email') }} @endif
                @if(company('abn')) · ABN {{ company('abn') }} @endif
            </div>
        </div>
    </div>

    <div class="cert-title">
        <h1>{{ $certificate->type === 'coes' ? 'Certificate of Electrical Safety' : 'Test & Tag Compliance Record' }}</h1>
        <div class="cert-number">{{ $certificate->certificate_number }}</div>
        <div style="margin-top:8px;">
            <span class="status-pill {{ in_array($certificate->status, ['compliant', 'pass']) ? 'status-pass' : 'status-fail' }}">
                {{ str_replace('_', ' ', ucfirst($certificate->status)) }}
            </span>
        </div>
    </div>

    <table class="info">
        <tr>
            <td class="label">Client Name</td>
            <td>{{ $certificate->client_name }}</td>
            <td class="label">Site Address</td>
            <td>{{ $certificate->address }}</td>
        </tr>
        <tr>
            <td class="label">Issued Date</td>
            <td>{{ $certificate->issued_date->format('d-m-Y') }}</td>
            <td class="label">{{ $certificate->type === 'coes' ? 'Expiry Date' : 'Next Test Due' }}</td>
            <td>{{ $certificate->expiry_date ? $certificate->expiry_date->format('d-m-Y') : '—' }}</td>
        </tr>
        <tr>
            <td class="label">Electrician</td>
            <td>{{ $certificate->electrician_name ?? '—' }}</td>
            <td class="label">Licence Number</td>
            <td>{{ $certificate->licence_number ?? '—' }}</td>
        </tr>
        @if($certificate->safetyCheckReport)
        <tr>
            <td class="label">Linked Safety Check Report</td>
            <td colspan="3">#{{ $certificate->safetyCheckReport->id }} — {{ \Carbon\Carbon::parse($certificate->safetyCheckReport->report_date)->format('d-m-Y') }}</td>
        </tr>
        @endif
    </table>

    @if($certificate->type === 'test_and_tag')
        <h3 class="section-title">Appliance Register</h3>
        <table class="items">
            <thead>
                <tr>
                    <th>Appliance</th>
                    <th>Tag Number</th>
                    <th>Result</th>
                    <th>Retest Date</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($certificate->items as $item)
                    <tr>
                        <td>{{ $item->appliance_name }}</td>
                        <td>{{ $item->tag_number ?? '—' }}</td>
                        <td class="result-{{ $item->test_result }}">{{ ucfirst($item->test_result) }}</td>
                        <td>{{ $item->retest_date ? $item->retest_date->format('d-m-Y') : '—' }}</td>
                        <td>{{ $item->notes ?? '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5">No appliances recorded.</td></tr>
                @endforelse
            </tbody>
        </table>
    @endif

    @if($certificate->notes)
        <h3 class="section-title">Notes</h3>
        <p>{{ $certificate->notes }}</p>
    @endif

    <div class="declaration">
        @if($certificate->type === 'coes')
            I certify that the electrical installation work described in this certificate has been
            carried out in accordance with AS/NZS 3000 (Wiring Rules) and relevant Australian
            electrical safety legislation, and is safe to use for its intended purpose.
        @else
            I certify that the electrical appliances listed above have been tested in accordance with
            AS/NZS 3760 (In-service safety inspection and testing of electrical equipment) and are
            marked and recorded as indicated.
        @endif
    </div>

    <div class="signature-block">
        <div class="signature-box">
            <div class="signature-line">Electrician Signature</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">Date</div>
        </div>
    </div>

    <div class="footer-note">
        Generated by {{ company('company_name', 'Latin Electrical') }} · {{ now()->format('d-m-Y H:i') }}
    </div>

</body>
</html>
