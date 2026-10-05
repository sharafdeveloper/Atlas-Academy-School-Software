@extends('layouts.app')
 
@section('title', 'Fee Receipt')
 
@section('content')
 
<div class="receipt-page">
 
 
{{-- =========================================
     PAGE ACTIONS
========================================== --}}
 
<div class="receipt-actions">
 
    <a
        href="{{ route('enrolled-students.index') }}"
        class="secondary-btn"
    >
        ← Back
    </a>
 
    <button
        type="button"
        onclick="window.print()"
        class="print-btn"
    >
        🖨 Print Receipt
    </button>
 
</div>
 
 
{{-- =========================================
     FEE RECEIPT
========================================== --}}
 
<div class="fee-receipt">
 
   <div class="receipt-header-header">
     <div class="receipt-header-image">
        <div class="receipt-image">
        <img src="{{ asset('Logo.jpg')}}" alt="Logo">
        </div>
 
    </div>
 
    <div class="receipt-header-title">
        <div class="receipt-sir">
            Sir Shahbaz's
        </div>
 
        <div class="receipt-academy">
            ATLAS ACADEMY
        </div>
 
        <div class="receipt-tagline">
            Access Towards Leading & Acme Success
        </div>
 
    </div>
   </div>
    {{-- =========================================
         ACADEMY HEADER
    ========================================== --}}
 
 
 
    {{-- =========================================
         RECEIPT TITLE
    ========================================== --}}
 
    <div class="receipt-title">
        FEE RECEIPT
    </div>
 
 
    {{-- =========================================
         RECEIPT META
    ========================================== --}}
 
    <div class="receipt-meta">
 
        {{-- Receipt Number --}}
        <div>
            <span>Receipt No:</span>
 
            <strong>
                {{ $payment->id }}
            </strong>
        </div>
 
 
        {{-- Date --}}
        <div>
            <span>Date:</span>
 
            <strong>
                {{ now()->format('d F Y') }}
            </strong>
        </div>
 
 
        {{-- Time --}}
        <div>
            <span>Time:</span>
 
            <strong>
                @if($payment->fee_time)
                    {{ \Carbon\Carbon::parse($payment->fee_time)->format('h:i A') }}
                @else
                    N/A
                @endif
            </strong>
        </div>
 
    </div>
 
 
    {{-- =========================================
         STUDENT INFORMATION
    ========================================== --}}
 
    <div class="receipt-section">
 
        <h3>
            Student Information
        </h3>
 
 
        <div class="receipt-grid">
 
 
            {{-- Student Name --}}
            <div>
 
                <span>
                    Student's Name
                </span>
 
                <strong>
                    {{ $payment->enrolledStudent->name ?? 'N/A' }}
                </strong>
 
            </div>
 
 
            {{-- Father Name --}}
            <div>
 
                <span>
                    Father/Guardian Name
                </span>
 
                <strong>
                    {{ $payment->enrolledStudent->father_name ?? 'N/A' }}
                </strong>
 
            </div>
 
 
            {{-- Date of Admission --}}
            <div>
 
                <span>
                    Date of Admission
                </span>
 
                <strong>
                 {{ $payment->enrolledStudent->date_of_admission ?? 'N/A' }}
                </strong>
 
            </div>
 
 
            {{-- Student's Code --}}
            <div>
 
                <span>
                    Student's Code
                </span>
 
                <strong>
                    {{ $payment->enrolledStudent->student_code ?? 'N/A' }}
                </strong>
 
            </div>
 
 
            {{-- Class --}}
            <div>
 
                <span>
                    Class
                </span>
 
                <strong>
                   {{ $payment->enrolledStudent->class ?? 'N/A' }}
                </strong>
 
            </div>
 
 
            {{-- Section --}}
            <div>
 
                <span>
                    Section
                </span>
 
                <strong>
                    {{ $payment->enrolledStudent->section ?? 'N/A' }}
                </strong>
 
            </div>
 
 
            {{-- Timing --}}
            <div>
 
                <span>
                    Timing
                </span>
 
                <strong>
                    <p>7:15 to 8:45</p>
                </strong>
 
            </div>
 
 
            {{-- Subject(s) Selected --}}
            <div>
 
                <span>
                    Subject(s) Selected
                </span>
 
                <strong>
                     {{ $payment->enrolledStudent->subjects_count ?? 'N/A' }}
                </strong>
 
            </div>
 
 
            {{-- Board --}}
            <div>
 
                <span>
                    Board
                </span>
 
                <strong>
                    {{ $payment->enrolledStudent->board ?? 'N/A' }}
                </strong>
 
            </div>
 
 
            {{-- Fee Month --}}
            <div>
 
                <span>
                    Fee Month
                </span>
 
                <strong>
                    {{ $payment->fee_month ?? 'N/A' }}
                </strong>
 
            </div>
 
 
 
        </div>
 
    </div>
 
 
    {{-- =========================================
         FEE PARTICULARS
    ========================================== --}}
 
    <div class="receipt-section">
 
        <table class="fee-table">
 
            <thead>
 
                <tr>
 
                    <th>
                        Fee Particulars
                    </th>
 
                    <th>
                        Amount
                    </th>
 
                </tr>
 
            </thead>
 
 
            <tbody>
 
 
                {{-- Admission Fee --}}
                <tr>
 
                    <td>
                        Admission Fee
                    </td>
 
                    <td>
                        Rs.
                        {{ number_format(
                            $payment->admission_fee ?? 0,
                            2
                        ) }}
                    </td>
 
                </tr>
 
 
                {{-- Tuition Fee --}}
                <tr>
 
                    <td>
                        Tuition Fee
                    </td>
 
                    <td>
                        Rs.
                        {{ number_format($payment->tuition_fee ?? 0, 2) }}
                    </td>
 
                </tr>
 
 
                {{-- Arrears --}}
                <tr>
 
                    <td>
                        Arrears
                    </td>
 
                    <td>
                        Rs.
                        {{ number_format($payment->arrears ?? 0, 2) }}
                    </td>
 
                </tr>
 
 
                {{-- Total Fees (Admission + Tuition + Arrears) --}}
                <tr class="fee-total">
 
                    <td>
                        Total Fees
                    </td>
 
                    <td>
                        Rs.
                        {{ number_format($payment->total_fees ?? 0, 2) }}
                    </td>
 
                </tr>
 
 
                {{-- Scholarship/Discount --}}
                <tr class="fee-total">
 
                    <td>
                        Scholarship/Discount
                    </td>
 
                    <td>
                        Rs.
                        {{ number_format($payment->discount ?? 0, 2) }}
                    </td>
 
                </tr>
 
 
                {{-- Previous Advance (only shown if it exists, applied AFTER discount, BEFORE net payable) --}}
                @if(($payment->previous_advance ?? 0) > 0)
 
                    <tr>
 
                        <td>
                            Previous Advance
                        </td>
 
                        <td>
                            - Rs.
                            {{ number_format($payment->previous_advance, 2) }}
                        </td>
 
                    </tr>
 
                @endif
 
 
                {{-- Net Payable Fee --}}
                <tr class="fee-total">
 
                    <td>
                        Net Payable Fee
                    </td>
 
                    <td>
                        Rs.
                        {{ number_format($payment->net_payable ?? 0, 2) }}
                    </td>
 
                </tr>
 
 
                {{-- Amount Received --}}
                <tr class="fee-total">
 
                    <td>
                        Amount Received
                    </td>
 
                    <td>
                        Rs.
                        {{ number_format($payment->amount_received ?? 0, 2) }}
                    </td>
 
                </tr>
 
 
                {{-- Balance --}}
                <tr class="fee-total">
 
                    <td>
                        Balance
                    </td>
 
                    <td>
                        Rs.
                        {{ number_format(max(0, ($payment->net_payable ?? 0) - ($payment->amount_received ?? 0)), 2) }}
                    </td>
 
                </tr>
 
            </tbody>
 
        </table>
 
    </div>
 
 
    {{-- =========================================
         REMAINING / ADVANCE
    ========================================== --}}
 
    @if(($payment->remaining_amount ?? 0) > 0)
 
        <div class="receipt-balance warning">
 
            <span>
                Remaining Amount
            </span>
 
            <strong>
                Rs.
                {{ number_format(
                    $payment->remaining_amount,
                    2
                ) }}
            </strong>
 
        </div>
 
    @elseif(($payment->advance_amount ?? 0) > 0)
 
        <div class="receipt-balance success">
 
            <span>
                Advance Amount
            </span>
 
            <strong>
                Rs.
                {{ number_format(
                    $payment->advance_amount,
                    2
                ) }}
            </strong>
 
        </div>
 
 
    @else
 
        <div class="receipt-balance success">
 
            <span>
                Payment Status
            </span>
 
            <strong>
                PAID
            </strong>
 
        </div>
 
    @endif
 
 
    {{-- =========================================
         FOOTER
    ========================================== --}}
 
    <div class="receipt-footer">
 
 
 
        <p class="thankyouword">
            "Thank you for paying fee timely"
        </p>
 
        <span>
            This is a computer-generated fee receipt.
        </span>
 
    </div>
 
</div>
 
</div>
 
@endsection
 
<style>
 
/* =========================================
   THERMAL RECEIPT - 80MM
========================================= */
 
.fee-receipt {
 
    width: 80mm;
    max-width: 80mm;
 
    margin: 30px auto;
 
    background: #ffffff;
 
    padding: 6mm;
 
    box-sizing: border-box;
}
 
 
/* =========================================
   PRINT SETTINGS
========================================= */
 
@media print {
 
    @page {
 
        size: 80mm auto;
 
        margin: 0;
    }
 
 
    html,
    body {
 
        width: 80mm !important;
 
        min-width: 80mm !important;
 
        max-width: 80mm !important;
 
        margin: 0 !important;
 
        padding: 0 !important;
 
        background: #ffffff !important;
    }
 
 
    /* Hide application layout */
 
    .sidebar,
    .top-header,
    .academy-header,
    .header-content,
    .academy-heading,
    .receipt-actions,
    .page-header,
    .page-content > .alert-success {
 
        display: none !important;
    }
 
 
    /* Remove dashboard layout */
 
    .app-layout,
    .main-area {
 
        display: block !important;
 
        width: 80mm !important;
 
        min-width: 80mm !important;
 
        max-width: 80mm !important;
 
        margin: 0 !important;
 
        padding: 0 !important;
    }
 
 
    .page-content {
 
        width: 80mm !important;
 
        min-width: 80mm !important;
 
        max-width: 80mm !important;
 
        margin: 0 !important;
 
        padding: 0 !important;
    }
 
 
    .receipt-page {
 
        width: 80mm !important;
 
        max-width: 80mm !important;
 
        margin: 0 !important;
 
        padding: 0 !important;
    }
 
 
    .fee-receipt {
 
        width: 80mm !important;
 
        max-width: 80mm !important;
 
        margin: 0 !important;
 
        padding: 5mm !important;
 
        box-sizing: border-box;
 
        box-shadow: none !important;
 
        border: none !important;
 
        background: #ffffff !important;
    }
 
 
    /* Prevent unnecessary page breaks */
 
    .receipt-section,
    .receipt-balance,
    .receipt-footer {
 
        page-break-inside: avoid;
 
        break-inside: avoid;
    }
 
 
    /* Remove links/buttons from print */
 
    button,
    a {
 
        text-decoration: none !important;
    }
 
}
 
</style>