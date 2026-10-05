@extends('layouts.app')

@section('title', 'Collect Fee')

@section('content')

<div class="page-header">

    <div>
        <h1 class="page-title">Collect Student Fee</h1>

        <p class="page-subtitle">
            Record monthly tuition fee payment
        </p>
    </div>

    <a
        href="{{ route('enrolled-students.index') }}"
        class="secondary-btn"
    >
        ← Back to Students
    </a>

</div>


<div class="form-card">

    <form
        action="{{ route('fee-payments.store', $student->id) }}"
        method="POST"
    >

        @csrf


        {{-- =========================
             STUDENT INFORMATION
        ========================== --}}

        <div class="form-section">

            <div class="form-section-header">

                <div class="section-icon">
                    👤
                </div>

                <div>
                    <h2>Student Information</h2>

                    <p>
                        Student details
                    </p>
                </div>

            </div>


            <div class="form-grid">

                <div class="form-group">

                    <label>
                        Student Name
                    </label>

                    <input
                        type="text"
                        class="form-input"
                        value="{{ $student->name }}"
                        readonly
                    >

                </div>


                <div class="form-group">

                    <label>
                        Father Name
                    </label>

                    <input
                        type="text"
                        class="form-input"
                        value="{{ $student->father_name }}"
                        readonly
                    >

                </div>


                <div class="form-group">

                    <label>
                        Class
                    </label>

                    <input
                        type="text"
                        class="form-input"
                        value="{{ $student->class }}"
                        readonly
                    >

                </div>


                <div class="form-group">

                    <label>
                        Board
                    </label>

                    <input
                        type="text"
                        class="form-input"
                        value="{{ $student->board }}"
                        readonly
                    >

                </div>

            </div>

        </div>


        {{-- =========================
             FEE INFORMATION
        ========================== --}}

        <div class="form-section">

            <div class="form-section-header">

                <div class="section-icon">
                    ₨
                </div>

                <div>

                    <h2>Fee Information</h2>

                    <p>
                        Current monthly fee details
                    </p>

                </div>

            </div>


            <div class="form-grid">


                {{-- Current Month --}}

                <div class="form-group">

                    <label>
                        Fee Month
                    </label>

                    <input
                        type="text"
                        class="form-input"
                        value="{{ $currentMonth }}"
                        readonly
                    >

                </div>


                {{-- Payment Date --}}

                <div class="form-group">

                    <label>
                        Payment Date
                    </label>

                    <input
                        type="text"
                        class="form-input"
                        value="{{ now()->format('d F Y') }}"
                        readonly
                    >

                </div>


                {{-- Payment Time --}}

                <div class="form-group">

                    <label>
                        Payment Time
                    </label>

                    <input
                        type="text"
                        class="form-input"
                        value="{{ now()->format('h:i A') }}"
                        readonly
                    >

                </div>


                {{-- Current Month Tuition --}}

                <div class="form-group">

                    <label>
                        Current Month Tuition Fee
                    </label>

                    <input
                        type="text"
                        class="form-input"
                        value="Rs. {{ number_format($tuitionFee, 2) }}"
                        readonly
                    >

                </div>


                {{-- Admission Fee --}}

                @if($admissionFee > 0)

                    <div class="form-group">

                        <label>
                            Admission Fee
                        </label>

                        <input
                            type="text"
                            class="form-input"
                            value="Rs. {{ number_format($admissionFee, 2) }}"
                            readonly
                        >

                    </div>

                @endif


                {{-- Admission Fee Waiver --}}

                @if($admissionFeeWaiver > 0)

                    <div class="form-group">

                        <label>
                            Admission Fee Waiver
                        </label>

                        <input
                            type="text"
                            class="form-input"
                            value="Rs. {{ number_format($admissionFeeWaiver, 2) }}"
                            readonly
                        >

                    </div>

                @endif


                {{-- Arrears --}}

                <div class="form-group">

                    <label>
                        Previous Arrears
                    </label>

                    <input
                        type="text"
                        class="form-input"
                        value="Rs. {{ number_format($arrears, 2) }}"
                        readonly
                    >

                </div>


                {{-- Previous Advance --}}

                @if($previousAdvance > 0)

                    <div class="form-group">

                        <label>
                            Previous Advance
                        </label>

                        <input
                            type="text"
                            class="form-input"
                            value="Rs. {{ number_format($previousAdvance, 2) }}"
                            readonly
                        >

                    </div>

                @endif


                {{-- Total Payable --}}

                <div class="form-group">

                    <label>
                        Total Amount To Be Paid
                    </label>

                    <input
                        type="text"
                        class="form-input"
                        value="Rs. {{ number_format($netPayable, 2) }}"
                        readonly
                    >

                </div>


                {{-- Amount Received --}}

                <div class="form-group">

                    <label for="amount_received">
                        Amount Received
                        <span>*</span>
                    </label>

                    <input
                        type="number"
                        id="amount_received"
                        name="amount_received"
                        class="form-input"
                        placeholder="Enter complete amount"
                        min="{{ $netPayable }}"
                        step="0.01"
                        required
                        autofocus
                    >

                    <small style="display:block; margin-top:6px; color:#666;">
                        Partial payment is not allowed.
                    </small>

                    @error('amount_received')

                        <small class="form-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>

            </div>

        </div>


        {{-- =========================
             UNPAID MONTHS
        ========================== --}}

        @if(count($unpaidMonths) > 0)

            <div class="form-section">

                <div class="form-section-header">

                    <div class="section-icon">
                        📋
                    </div>

                    <div>

                        <h2>Unpaid Monthly Fees</h2>

                        <p>
                            Previous unpaid months included in arrears
                        </p>

                    </div>

                </div>


                <div style="overflow-x:auto;">

                    <table style="width:100%; border-collapse:collapse;">

                        <thead>

                            <tr>

                                <th style="text-align:left; padding:10px;">
                                    Month
                                </th>

                                <th style="text-align:right; padding:10px;">
                                    Fee
                                </th>

                                <th style="text-align:right; padding:10px;">
                                    Paid
                                </th>

                                <th style="text-align:right; padding:10px;">
                                    Remaining
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($unpaidMonths as $month)

                                <tr>

                                    <td style="padding:10px;">
                                        {{ $month['month'] }}
                                    </td>

                                    <td style="padding:10px; text-align:right;">
                                        Rs. {{ number_format($month['tuition_fee'], 2) }}
                                    </td>

                                    <td style="padding:10px; text-align:right;">
                                        Rs. {{ number_format($month['allocated'], 2) }}
                                    </td>

                                    <td style="padding:10px; text-align:right;">
                                        Rs. {{ number_format($month['remaining'], 2) }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        @endif


        {{-- =========================
             ACTIONS
        ========================== --}}

        <div class="form-footer">

            <a
                href="{{ route('enrolled-students.index') }}"
                class="cancel-btn"
            >
                Cancel
            </a>


            <button
                type="submit"
                class="save-btn"
            >
                Collect Fee
            </button>

        </div>

    </form>

</div>

@endsection

