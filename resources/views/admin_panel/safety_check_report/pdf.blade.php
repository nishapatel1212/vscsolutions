<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <title>Safety Check Report Summary</title>

    <style>
        @page {
            margin: 30px;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            background: #ffffff;
            color: #333;
            font-size: 11px;
        }

        .container {
            width: 100%;
            padding: 5px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 30px;
            border-radius: 5px;
            overflow: hidden;
        }

        .section-header {
            background: #d1c516;
            color: #fff;
            padding: 8px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            max-width: 100%;
            table-layout: fixed;
            /* prevents overflow */
        }

        table td,
        table th {
            border: 1px solid #ddd;
            padding: 4px 6px;
        }

        table th {
            background: #f9f9f9;
            text-align: left;
        }

        .label {
            width: 30%;
            font-weight: bold;
            background: #f9f9f9;
        }

        .value {
            width: 70%;
        }

        .text-center {
            text-align: center;
        }

        .text-danger {
            color: red;
        }

        .text-success {
            color: green;
        }

        .first-page {
            page-break-after: always;
            text-align: center;
            padding-top: 150px;
        }

        .first-page img {
            width: 500px;
            /* logo size */
            height: 200px;
        }

        .first-page h1 {
            margin-top: 20px;
            font-size: 32px;
            color: #000000;
        }
    </style>

</head>

<body>
    {{-- <div class="first-page">
        <img src="{{ asset('images/logo/vaishu_logo.png') }}" alt="VSC Solutions Logo">
        <h1>Electrical Safety &amp; Compliance Report</h1>
    </div> --}}

    <div class="container">


        <h1>Safety Check Report Summary</h1>

        <!-- DETAILS -->
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

        <!-- CHECKS -->
        <div class="section">
            <div class="section-header">Checks Conducted And Outcomes</div>
            <table>
                <tr>
                    <td>Electrical Safety Check</td>
                    <td text-align="right">
                        <strong> {{ $data->safety_check_status ?? 'Faults Identified' }} </strong>
                    </td>
                </tr>
            </table>
        </div>

        <!-- CONTACT -->
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

        <!-- OBSERVATIONS -->
        <div class="section">
            <div class="section-header">
                Observations And Recommendations For Any Actions To Be Taken
            </div>

            <table>
                <tr>
                    <th>Fault</th>
                    <th>Required Rectification</th>
                    <th>Repair Completed?</th>
                    <th>Assessment</th>
                </tr>

                @if (!empty($data->faults))
                    @foreach($data->faults as $index => $fault)
                        <tr>
                            <td>{{ $fault->fault ?? '' }}</td>
                            <td>{{ $fault->required_rectification ?? '' }}</td>
                            <td>{{ $fault->repair_completed ?? '' }}</td>
                            <td>{{ $fault->assessment ?? '' }}</td>
                        </tr>
                    @endforeach
                @endif

            </table>
        </div>

        <!-- DETAILS -->
        <div class="section">
            <div class="section-header">A. Installation Address</div>
            <table>
                <tr>
                    <td class="label">Address:</td>
                    <td class="value">{{ $data->address }}</td>
                </tr>
                <tr>
                    <td class="label">Date of previous Safety Check (if any) (Not Sure):</td>
                    <td class="value">{{ !empty($data->previous_safety_date) ? \Carbon\Carbon::parse($data->previous_safety_date)->format('M d, Y') : '' }}</td>
                </tr>
            </table>
        </div>

    </div>

</body>

</html>