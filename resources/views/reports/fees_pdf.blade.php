<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Fee Collection Report</title>
    <style>
        @page { margin: 25px 30px 50px 30px; }

        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 11px;
            color: #1f2937;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        /* ---------- Letterhead ---------- */
        .lh { width: 100%; border-collapse: collapse; }
        .lh td { vertical-align: middle; padding: 0; }
        .lh-left { width: auto; }
        .receipt-header-header { display: table; }
        .receipt-header-image,
        .receipt-header-title { display: table-cell; vertical-align: middle; }
        .receipt-header-image { padding-right: 8px; }
        .receipt-image img { height: 60px; width: auto; }
        .receipt-sir {
            font-family: 'DejaVu Serif', serif;
            font-style: italic;
            font-weight: bold;
            font-size: 15px;
            color: #000000;
            margin-bottom: -2px;
        }
        .receipt-academy {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 31px;
            font-weight: bold;
            letter-spacing: 1.5px;
            color: #000000;
            line-height: 1.05;
        }
        .receipt-tagline {
            font-size: 10px;
            font-weight: bold;
            color: #000000;
        }
        .lh-contact {
            width: 190px;
            font-size: 11px;
            font-weight: bold;
            line-height: 1.3;
            color: #000000;
        }
        .lh-contact .indent { padding-left: 62px; }
        .lh-strip {
            border-top: 1px solid #000000;
            margin-top: 6px;
            padding-top: 2px;
            font-size: 6.5px;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            color: #000000;
            margin-bottom: 8px;
        }

        /* ---------- Title ---------- */
        .report-title {
            text-align: center;
            color: #000000;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin: 14px 0 4px 0;
        }
        .title-line {
            width: 90px;
            height: 3px;
            background-color: #1e4fa3;
            margin: 0 auto 16px auto;
        }

        /* ---------- Meta cards ---------- */
        .meta-table { width: 100%; border-collapse: separate; border-spacing: 6px 0; margin: 0 -6px 16px -6px; }
        .meta-cell {
            width: 25%;
            background-color: #f1f6fd;
            border: 1px solid #d3e2f7;
            border-left: 4px solid #1e4fa3;
            padding: 7px 10px;
        }
        .meta-label {
            font-size: 8.5px;
            color: #6b7f9e;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }
        .meta-value {
            font-size: 12px;
            font-weight: bold;
            color: #0f2a55;
            margin-top: 2px;
        }

        /* ---------- Data table ---------- */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table thead { display: table-header-group; }
        .data-table tr { page-break-inside: avoid; }

        .data-table th {
            background-color: #1e4fa3;
            color: #ffffff;
            border: 1px solid #1e4fa3;
            border-bottom: 3px solid #0f2a55;
            padding: 9px 8px;
            font-size: 9.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            text-align: left;
        }
        .data-table td {
            border: 1px solid #dbe5f3;
            padding: 7px 8px;
            font-size: 10px;
            color: #1f2937;
            vertical-align: middle;
        }
        .data-table tr.alt td { background-color: #f4f8fd; }

        .text-center { text-align: center; }
        .text-right  { text-align: right; }

        .student-name { font-weight: bold; color: #0f2a55; }
        .student-code { color: #6b7280; font-size: 8.5px; }
        .time-small   { color: #6b7280; font-size: 8.5px; }
        .amount       { text-align: right; font-weight: bold; color: #1e4fa3; white-space: nowrap; }
        .empty-row    { padding: 22px; text-align: center; color: #6b7280; }

        /* ---------- Totals ---------- */
        .footer-table { width: 100%; border-collapse: collapse; margin-top: 16px; page-break-inside: avoid; }
        .note { font-size: 9px; color: #6b7280; vertical-align: bottom; }

        .summary-box { width: 100%; border-collapse: collapse; border: 1px solid #c7d8f0; }
        .summary-box td { padding: 7px 12px; font-size: 11px; background-color: #f4f8fd; }
        .summary-box tr.grand-total td {
            background-color: #1e4fa3;
            color: #ffffff;
            font-size: 12.5px;
            font-weight: bold;
        }

        /* ---------- Fixed page footer ---------- */
        .page-footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            border-top: 1px solid #1e4fa3;
            padding-top: 5px;
            font-size: 8.5px;
            color: #6b7280;
            text-align: center;
        }
        .page-number:after { content: counter(page); }
    </style>
</head>
<body>

    <!-- Letterhead (pure HTML/CSS, no image) -->
    <table class="lh">
        <tr>
            <td class="lh-left">
                <div class="receipt-header-header">
                    <div class="receipt-header-image">
                        <div class="receipt-image">
                            <img src="{{ public_path('Logo.jpg') }}" alt="Logo">
                        </div>
                    </div>

                    <div class="receipt-header-title">
                        <div class="receipt-sir">Sir Shahbaz's</div>
                        <div class="receipt-academy">ATLAS ACADEMY</div>
                        <div class="receipt-tagline">Access Towards Leading &amp; Acme Success</div>
                    </div>
                </div>
            </td>
            <td class="lh-contact">
                Plot # A&ndash;2 Block &ldquo;E&rdquo;<br>
                Gulshan - e - Jamal<br>
                Contact No: 021 &ndash; 34581125<br>
                <span class="indent">0333 &ndash; 1476200</span><br>
                <span class="indent">0333 &ndash; 2454916</span>
            </td>
        </tr>
    </table>
    <div class="lh-strip">*** 27 years of Excellence * Success with in Access * 27 years of Excellence * Success with in Access * 27 years of Excellence * Success with in Access ***</div>

    <!-- Title -->
    <div class="report-title">Fee Collection &amp; Payment Report</div>
    <div class="title-line"></div>

    <!-- Meta -->
    <table class="meta-table">
        <tr>
            <td class="meta-cell">
                <div class="meta-label">Filter Month</div>
                <div class="meta-value">{{ $selectedMonth }}</div>
            </td>
            <td class="meta-cell">
                <div class="meta-label">Collected By</div>
                <div class="meta-value">{{ $collectorName }}</div>
            </td>
            <td class="meta-cell">
                <div class="meta-label">Total Transactions</div>
                <div class="meta-value">{{ number_format($totalPayments) }}</div>
            </td>
            <td class="meta-cell">
                <div class="meta-label">Report Generated</div>
                <div class="meta-value" style="font-size: 10.5px;">{{ now()->format('d M Y, h:i A') }}</div>
            </td>
        </tr>
    </table>

    <!-- Records -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">#</th>
                <th style="width: 25%;">Student</th>
                <th style="width: 10%;" class="text-center">Class</th>
                <th style="width: 17%;">Board</th>
                <th style="width: 14%;">Fee Month</th>
                <th style="width: 14%;">Date &amp; Time</th>
                <th style="width: 15%;" class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $index => $payment)
                <tr class="{{ $loop->even ? 'alt' : '' }}">
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <span class="student-name">{{ $payment->enrolledStudent->name ?? 'N/A' }}</span>
                        @if(!empty($payment->enrolledStudent->student_code))
                            <br><span class="student-code">Code: {{ $payment->enrolledStudent->student_code }}</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $payment->enrolledStudent->class ?? '-' }}</td>
                    <td>{{ $payment->enrolledStudent->board ?? '-' }}</td>
                    <td>{{ $payment->fee_month ?? '-' }}</td>
                    <td>
                        {{ $payment->fee_date ?? '' }}
                        @if(!empty($payment->fee_time))
                            <br><span class="time-small">{{ $payment->fee_time }}</span>
                        @endif
                    </td>
                    <td class="amount">Rs. {{ number_format($payment->amount_received, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="empty-row">No fee payment records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Totals -->
    <table class="footer-table">
        <tr>
            <td class="note"><em>* Computer generated document, requires no official signature.</em></td>
            <td style="width: 260px;">
                <table class="summary-box">
                    <tr>
                        <td>Total Transactions</td>
                        <td class="text-right"><strong>{{ number_format($totalPayments) }}</strong></td>
                    </tr>
                    <tr class="grand-total">
                        <td>Total Collected</td>
                        <td class="text-right">Rs. {{ number_format($totalAmountCollected, 2) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Page footer -->
    <div class="page-footer">
        Atlas Academy Management System &bull; Printed {{ now()->format('Y-m-d H:i:s') }} &bull; Page <span class="page-number"></span>
    </div>

</body>
</html>