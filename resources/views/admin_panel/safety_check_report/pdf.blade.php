<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Safety Check Report</title>
    <style>
        @page { margin: 0; }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            background: #ffffff;
            color: #333;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }

        /* ─── PAGES ─────────────────────────────── */
        .page { page-break-after: always; }
        .page-inner { padding: 30px; }

        /* ─── COVER PAGE ─────────────────────────── */
        .cover {
            position: relative;
            width: 100%;
            height: 100%;
            min-height: 1050px;
            background: #ffffff;
            overflow: hidden;
        }
        .cover-header {
            padding: 20px 30px;
            text-align: right;
        }
        .cover-logo { height: 50px; }
        .cover-images {
            width: 100%;
            position: relative;
        }
        .cover-images img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            display: block;
        }
        .cover-diagonal {
            position: absolute;
            top: 0; left: 120px;
            width: 80px;
            height: 100%;
            background: #e8581c;
            transform: skewX(-10deg);
        }
        .cover-body {
            padding: 40px 30px 20px 20px;
        }
        .cover-brand {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }
        .cover-brand img { height: 30px; }
        .cover-title {
            font-size:50px;
            font-weight: bold;
            color: #222;
            line-height: 1.2;
            margin-bottom: 30px;
        }
        .cover-subtitle {
            font-size: 25px;
            font-weight: bold;
            color: #333;
            margin-bottom: 40px;
        }
        .cover-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            font-size: 10px;
            color: #555;
            border-top: 1px solid #ddd;
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
        }
        .cover-social span {
            display: inline-block;
            width: 22px; height: 22px;
            border-radius: 50%;
            background: #e8581c;
            margin-left: 4px;
            text-align: center;
            line-height: 22px;
            color: #fff;
            font-size: 9px;
        }

        /* ─── SECTIONS ───────────────────────────── */
        .section { margin-bottom: 24px; border-radius: 4px; overflow: hidden; }

        .section-header {
            background: #e8581c;
            color: #fff;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            table-layout: fixed;
        }
        table td, table th {
            border: 1px solid #e0e0e0;
            padding: 5px 8px;
            vertical-align: top;
        }
        table th {
            background: #f5f5f5;
            font-weight: bold;
            font-size: 10px;
        }
        .label { width: 35%; font-weight: bold; background: #f9f9f9; }
        .value { width: 65%; }

        h1 { text-align: center; font-size: 20px; margin-bottom: 20px; color: #222; }

        /* ─── CHECKBOX GRID ──────────────────────── */
        .check-grid { width: 100%; border-collapse: collapse; }
        .check-grid td {
            border: 1px solid #e0e0e0;
            padding: 5px 8px;
            width: 42%;
            font-size: 10px;
        }
        .check-grid td.cb { width: 8%; text-align: center; border-left: none; }
        .check-grid td.spacer { width: 0%; border: none; padding: 0; }

        .checkbox {
            display: inline-block;
            width: 10px; height: 10px;
            border: 1.5px solid #e8581c;
            border-radius: 3px;
            text-align: center;
            line-height: 13px;
            font-size: 10px;
            color: #e8581c;
            vertical-align: middle;
        }
        .checked { background: #fff2ee; }

        /* ─── FAULTS TABLE ───────────────────────── */
        .faults-table th { background: #f5f5f5; }
        .faults-table td { font-size: 10px; vertical-align: top; }
        .fault-img { width: 80px; height: 70px; object-fit: cover; border-radius: 3px; }

        /* ─── ANNEX PHOTOS ───────────────────────── */
        .annex-row { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .annex-row td { border: 1px solid #e0e0e0; padding: 8px; vertical-align: top; }
        .annex-row td:first-child { width: 45%; font-size: 10px; color: #555; }
        .annex-row td:last-child { width: 55%; }
        .annex-row img { width: 100%; max-height: 450px; object-fit: cover; border-radius: 3px; }

        /* ─── CERTIFICATION ──────────────────────── */
        .cert-text { font-size: 10px; color: #444; padding: 8px; border: 1px solid #e0e0e0; }
        .sign-row { width: 100%; border-collapse: collapse; }
        .sign-row td { border: 1px solid #e0e0e0; padding: 8px; }

        /* ─── RCD / SMOKE ────────────────────────── */
        .info-box { border: 1px solid #e0e0e0; padding: 6px 10px; font-size: 10px; margin-bottom: 4px; }
    </style>
</head>
<body>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- PAGE 1 — COVER                                         --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<div class="page">
    <div class="cover">
        <div class="cover-header">
            <img class="cover-logo" src="{{ public_path('images/logo/vaishu_logo.png') }}" alt="Logo">
        </div>

  

        <div class="cover-body" style="text-align: center; width: 100%;">
            <div class="cover-brand">
                <img src="{{ public_path('images/logo/vaishu_logo.png') }}" alt="Logo" style="height:200px;width:500px;">
            </div>
            <div class="cover-title" style="text-align:center;">Safety and Compliance Report</div>
            <div class="cover-subtitle" style="text-align:center;">Electrical Check Safety Check Report</div>
        </div>

        <div class="cover-footer">
            <span>{{ $data->address }}</span>
            <span>{{ \Carbon\Carbon::parse($data->report_date)->format('M d, Y') }}</span>
            {{-- <span class="cover-social">
                <span>f</span><span>t</span><span>in</span>
            </span> --}}
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- PAGE 2 — REPORT SUMMARY                                --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<div class="page">
    <div class="page-inner">
        <h1>Safety Check Report Summary</h1>

        {{-- Details --}}
        <div class="section">
            <div class="section-header">Details</div>
            <table>
                <tr>
                    <td class="label">Property Address:</td>
                    <td class="value">{{ $data->address }}</td>
                </tr>
                <tr>
                    <td class="label">Date:</td>
                    <td class="value">{{ \Carbon\Carbon::parse($data->report_date)->format('M d, Y') }}</td>
                </tr>
            </table>
        </div>

        {{-- Checks Conducted --}}
        <div class="section">
            <div class="section-header">Checks Conducted And Outcomes</div>
            <table>
                <tr>
                    <td>Electrical Safety Check</td>
                    <td style="text-align:right;"><strong>{{ $data->safety_check_status ?? 'Faults Identified' }}</strong></td>
                </tr>
            </table>
        </div>

        {{-- Contact --}}
        <div class="section">
            <div class="section-header">Contact Us</div>
            <table>
                <tr>
                    <td class="label">Email:</td>
                    <td>info@vscsolutions.com.au</td>
                </tr>
                <tr>
                    <td class="label">Phone:</td>
                    <td>0422 221 164</td>
                </tr>
            </table>
        </div>

        {{-- Observations --}}
        <div class="section">
            <div class="section-header">Observations And Recommendations For Any Actions To Be Taken</div>
            <table class="faults-table">
                <tr>
                    <th>Fault</th>
                    <th>Required Rectification</th>
                    <th>Repair Completed?</th>
                    <th>Assessment</th>
                </tr>
                @forelse($data->faults as $fault)
                <tr>
                    <td>{{ $fault->fault ?? '' }}</td>
                    <td>{{ $fault->required_rectification ?? '' }}</td>
                    <td>{{ $fault->repair_completed ? 'Yes' : 'No' }}</td>
                    <td>{{ $fault->assessment ?? '' }}</td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:#999;">No faults recorded</td></tr>
                @endforelse
            </table>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- PAGE 3 — ELECTRICAL SAFETY CHECK REPORT (A, B, C, D)  --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<div class="page">
    <div class="page-inner">

        <div style="display:flex;gap:20px;margin-bottom:20px;">
            <div style="flex:1;">
                <div style="font-size:18px;font-weight:bold;color:#222;line-height:1.3;">Electrical Safety<br>Check – Report</div>
            </div>
            <div style="flex:2;font-size:9px;color:#555;border-left:3px solid #e8581c;padding-left:10px;">
                This electrical safety check is for electrical safety purposes only and is in accordance with the requirements of the
                Residential Tenancies Regulations 2021 and is prepared in accordance with section 2 of the Australian/New Zealand
                Standard AS/NZS 3019, Electrical installations— Periodic verification to confirm that the installation is not damaged
                or has not deteriorated so as to impair electrical safety; and to identify installation defects and departures from the
                requirements that may give rise to danger.
            </div>
        </div>

        {{-- A. Installation Address --}}
        <div class="section">
            <div class="section-header">A. Installation Address</div>
            <table>
                <tr>
                    <td class="label">Address:</td>
                    <td class="value">{{ $data->address }}</td>
                </tr>
                <tr>
                    <td class="label">Date of previous Safety Check (if any):</td>
                    <td class="value">{{ !empty($data->previous_safety_date) ? \Carbon\Carbon::parse($data->previous_safety_date)->format('M d, Y') : '' }}</td>
                </tr>
            </table>
        </div>

        {{-- B. Inspection Items --}}
        <div class="section">
            <div class="section-header">B. Extent Of The Installation And Limitations Of The Inspection And Testing</div>
            <table>
                <tr>
                    <td style="font-size:9px;color:#555;" colspan="4">Details of those parts of the installation and limitations of the safety check covered by this certificate</td>
                </tr>
            </table>
            @php
                $leftItems  = $data->inspectionItems->where('section', 'left')->values();
                $rightItems = $data->inspectionItems->where('section', 'right')->values();
                $allLeft    = \App\Models\InspectionItem::where('section','left')->get();
                $allRight   = \App\Models\InspectionItem::where('section','right')->get();
                $checkedIds = $data->inspectionItems->pluck('id')->toArray();
                $rows       = max($allLeft->count(), $allRight->count());
            @endphp
            <table class="check-grid">
                @for($i = 0; $i < $rows; $i++)
                @php
                    $l = $allLeft[$i] ?? null;
                    $r = $allRight[$i] ?? null;
                @endphp
                <tr>
                    <td>{{ $l?->name ?? '' }}</td>
                    <td class="cb">
                        @if($l)
                            <span class="checkbox {{ in_array($l->id, $checkedIds) ? 'checked' : '' }}">
                                {{ in_array($l->id, $checkedIds) ? '✓' : '' }}
                            </span>
                        @endif
                    </td>
                    <td>{{ $r?->name ?? '' }}</td>
                    <td class="cb">
                        @if($r)
                            <span class="checkbox {{ in_array($r->id, $checkedIds) ? 'checked' : '' }}">
                                {{ in_array($r->id, $checkedIds) ? '✓' : '' }}
                            </span>
                        @endif
                    </td>
                    <td style="border:none;width:5%;"></td>
                </tr>
                @endfor
            </table>
        </div>

        {{-- C. Visual Inspection --}}
        <div class="section">
            <div class="section-header">C. Safety Check - Verified By Visual Inspection</div>
            <table>
                <tr>
                    <td style="font-size:9px;color:#555;" colspan="4">
                        As far as practicable a VISUAL INSPECTION of the following items has been carried out per the requirements of section 3 and 4 of the Australian/New Zealand Standard AS/NZS 3019:2007 Electrical installations—Periodic Verification: strike out those parts of the installation if not applicable – mark NI if not included in the safety check – add additional information if required.
                    </td>
                </tr>
            </table>
            @php
                $vAllLeft    = \App\Models\VisualInspectionItem::where('section','left')->get();
                $vAllRight   = \App\Models\VisualInspectionItem::where('section','right')->get();
                $vCheckedIds = $data->visualInspectionItems->pluck('id')->toArray();
                $vRows       = max($vAllLeft->count(), $vAllRight->count());
            @endphp
            <table class="check-grid">
                @for($i = 0; $i < $vRows; $i++)
                @php $vl = $vAllLeft[$i] ?? null; $vr = $vAllRight[$i] ?? null; @endphp
                <tr>
                    <td>{{ $vl?->name ?? '' }}</td>
                    <td class="cb">
                        @if($vl)
                            <span class="checkbox {{ in_array($vl->id, $vCheckedIds) ? 'checked' : '' }}">
                                {{ in_array($vl->id, $vCheckedIds) ? '✓' : '' }}
                            </span>
                        @endif
                    </td>
                    <td>{{ $vr?->name ?? '' }}</td>
                    <td class="cb">
                        @if($vr)
                            <span class="checkbox {{ in_array($vr->id, $vCheckedIds) ? 'checked' : '' }}">
                                {{ in_array($vr->id, $vCheckedIds) ? '✓' : '' }}
                            </span>
                        @endif
                    </td>
                    <td style="border:none;width:5%;"></td>
                </tr>
                @endfor
            </table>
        </div>

        {{-- D. Header only --}}
        <div class="section">
            <div class="section-header">D. Safety Check - Verified By Testing</div>
            <table>
                <tr>
                    <td style="font-size:9px;color:#555;">
                        As far as practicable TESTING of the following items has been carried out per the requirements of 4 of the Australian/New Zealand Standard AS/NZS 3019:2007 Electrical installations—Periodic Verification: strike out those parts of the installation if not applicable – mark NI if not included in the safety check – add additional information if required
                    </td>
                </tr>
            </table>
        </div>

    </div>
</div>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- PAGE 4 — POLARITY, EARTH CONTINUITY, RCD, SMOKE ALARMS --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<div class="page">
    <div class="page-inner">

        {{-- Polarity --}}
        <div class="section">
            <div class="section-header">Polarity And Correct Connections Testing</div>
            @php
                $pAllLeft    = \App\Models\PolarityTestingItem::where('section','left')->get();
                $pAllRight   = \App\Models\PolarityTestingItem::where('section','right')->get();
                $pCheckedIds = $data->polarityTestingItems->pluck('id')->toArray();
                $pRows       = max($pAllLeft->count(), $pAllRight->count());
            @endphp
            <table class="check-grid">
                @for($i = 0; $i < $pRows; $i++)
                @php $pl = $pAllLeft[$i] ?? null; $pr = $pAllRight[$i] ?? null; @endphp
                <tr>
                    <td>{{ $pl?->name ?? '' }}</td>
                    <td class="cb">
                        @if($pl)
                            <span class="checkbox {{ in_array($pl->id, $pCheckedIds) ? 'checked' : '' }}">
                                {{ in_array($pl->id, $pCheckedIds) ? '✓' : '' }}
                            </span>
                        @endif
                    </td>
                    <td>{{ $pr?->name ?? '' }}</td>
                    <td class="cb">
                        @if($pr)
                            <span class="checkbox {{ in_array($pr->id, $pCheckedIds) ? 'checked' : '' }}">
                                {{ in_array($pr->id, $pCheckedIds) ? '✓' : '' }}
                            </span>
                        @endif
                    </td>
                    <td style="border:none;width:5%;"></td>
                </tr>
                @endfor
            </table>
        </div>

        {{-- Earth Continuity --}}
        <div class="section">
            <div class="section-header">Earth Continuity Testing</div>
            @php
                $eCheckedIds = $data->earthTestingItems->pluck('id')->toArray();
                $eRows       = max($eAllLeft->count(), $eAllRight->count());
            @endphp
            <table class="check-grid">
                @for($i = 0; $i < $eRows; $i++)
                @php $el = $eAllLeft[$i] ?? null; $er = $eAllRight[$i] ?? null; @endphp
                <tr>
                    <td>{{ $el?->name ?? '' }}</td>
                    <td class="cb">
                        @if($el)
                            <span class="checkbox {{ in_array($el->id, $eCheckedIds) ? 'checked' : '' }}">
                                {{ in_array($el->id, $eCheckedIds) ? '✓' : '' }}
                            </span>
                        @endif
                    </td>
                    <td>{{ $er?->name ?? '' }}</td>
                    <td class="cb">
                        @if($er)
                            <span class="checkbox {{ in_array($er->id, $eCheckedIds) ? 'checked' : '' }}">
                                {{ in_array($er->id, $eCheckedIds) ? '✓' : '' }}
                            </span>
                        @endif
                    </td>
                    <td style="border:none;width:5%;"></td>
                </tr>
                @endfor
            </table>
        </div>

        {{-- D Continued - RCD --}}
        <div class="section">
            <div class="section-header">D. Safety Check - Verified By Testing - Continued</div>
            <div class="info-box">RCD (residual-current device / safety switch) testing</div>
            <div class="info-box">{{ $data->rcd_details ?? 'All RCDS have passed push and time tests' }}</div>
        </div>

        {{-- E. Smoke Alarms --}}
        <div class="section">
            <div class="section-header">E. Smoke Alarms</div>
            <div class="info-box">
                {{ $data->smoke_alarm_details ?? 'A smoke alarm safety check has not been completed in this inspection. This report does not indicate whether smoke alarms on the property are compliant or non-compliant. Separate evaluation may be required.' }}
            </div>
        </div>

    </div>
</div>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- PAGE 5 — FAULTS DETAIL + CERTIFICATION                 --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<div class="page">
    <div class="page-inner">

        {{-- Faults with images --}}
        <div class="section">
            <div class="section-header">Details Of Identified Faults &amp; Remedial Action To Be Taken</div>
            <table class="faults-table">
                <tr>
                    <th>Identified Fault(s)</th>
                    <th>Rectification</th>
                    <th>Location</th>
                    <th>Assessment</th>
                    <th>Image</th>
                </tr>
                @forelse($data->faults as $fault)
                <tr>
                    <td>{{ $fault->fault ?? '' }}</td>
                    <td>{{ $fault->required_rectification ?? '' }}</td>
                    <td>{{ $fault->location ?? '' }}</td>
                    <td>{{ $fault->assessment ?? '' }}</td>
                    <td>
                        @if($fault->image_path)
                            <img class="fault-img" src="{{ storage_path('app/public/' . $fault->image_path) }}" alt="Fault Image">
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;color:#999;">No faults recorded</td></tr>
                @endforelse
            </table>
        </div>

        {{-- G. Certification --}}
        <div class="section">
            <div class="section-header">G. Electrical Safety Check Certification</div>
            <table>
                <tr>
                    <td class="label">Electrical Safety check completed by:</td>
                    <td class="value">{{ $data->electrician_name ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Licence/registration number:</td>
                    <td class="value">{{ $data->licence_number ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Inspection date:</td>
                    <td class="value">{{ \Carbon\Carbon::parse($data->report_date)->format('M d, Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Next inspection due by:</td>
                    <td class="value">{{ !empty($data->next_inspection_date) ? \Carbon\Carbon::parse($data->next_inspection_date)->format('M d, Y') : '' }}</td>
                </tr>
            </table>

            <div class="cert-text" style="margin-top:8px;">
                I, the above-named licensed electrician, have carried out an electrical safety check of this residential property in accordance with the Residential Tenancies Regulations 2021 and the Australian/New Zealand Standard AS/NZS 3019: "Electrical installations—Periodic verification."
            </div>

            <table class="sign-row" style="margin-top:8px;">
                <tr>
                    <td style="width:50%;">
                        <strong>Sign:</strong><br>
                        @if(!empty($data->signature_path))
                            <img src="{{ storage_path('app/public/' . $data->signature_path) }}" style="height:60px;margin-top:5px;">
                        @else
                            <div style="height:60px;"></div>
                        @endif
                    </td>
                    <td style="width:50%;">
                        <strong>Date:</strong> {{ \Carbon\Carbon::parse($data->report_date)->format('M d, Y') }}
                    </td>
                </tr>
            </table>
        </div>

    </div>
</div>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- PAGE 6+ — ANNEX PHOTOS                                 --}}
{{-- ═══════════════════════════════════════════════════════ --}}
@if($data->images->count())
<div class="page">
    <div class="page-inner">
        <div class="section">
            <div class="section-header" style="text-align:center;">Annex: Photos</div>
        </div>

        @foreach($data->images->chunk(2) as $chunk)
            @foreach($chunk as $image)
            <table class="annex-row" style="margin-bottom:10px;">
                <tr>
                    <td>{{ $image->title ?? '' }}</td>
                    <td>
                        <img src="{{ storage_path('app/public/' . $image->image_path) }}" alt="{{ $image->title }}">
                    </td>
                </tr>
            </table>
            @endforeach
        @endforeach

    </div>
</div>
@endif

</body>
</html>