@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="dashboard-page">


{{-- =========================================================
     DASHBOARD HEADER
========================================================== --}}

<div class="dashboard-header">

    <div>
        <div class="dashboard-eyebrow">
            ATLAS ACADEMY
        </div>

        <h1 class="dashboard-title">
            Dashboard
        </h1>

        <p class="dashboard-subtitle">
            Overview of academy finances and student activity
        </p>
    </div>


    {{-- Month Filter --}}

    {{-- Month Filter --}}
<form
    method="GET"
    action="{{ route('dashboard') }}"
    class="dashboard-filter"
>
    <span class="filter-label">
        Viewing
    </span>

    <select
        name="month"
        class="month-select"
        onchange="this.form.submit()"
    >
        @foreach($availableMonths as $month)
            <option
                value="{{ $month['value'] }}"
                {{ $selectedMonth === $month['value'] ? 'selected' : '' }}
            >
                {{ $month['label'] }}
            </option>
        @endforeach
    </select>
</form>

</div>


{{-- =========================================================
     FINANCIAL OVERVIEW
========================================================== --}}

<div class="dashboard-section-heading">

    <div>

        <h2>
            Financial Overview
        </h2>

        <p>
            Monthly income, expenses and outstanding amounts
        </p>

    </div>

</div>


<div class="dashboard-cards">


    {{-- =====================================================
         TOTAL FEES COLLECTED
    ====================================================== --}}

    <div class="dashboard-card fees-card">

        <div class="dashboard-card-top">

            <div class="dashboard-card-icon">
                ₨
            </div>

            <span class="dashboard-card-status positive">
                {{ $monthName }}
            </span>

        </div>


        <div class="dashboard-card-content">

            <span class="dashboard-card-label">
                Total Fees Collected
            </span>

            <h3>
                Rs. {{ number_format($totalFeesCollected, 2) }}
            </h3>

            <p>
                Total student payments received
            </p>

        </div>

    </div>


    {{-- =====================================================
         TEACHER SALARIES PAID
    ====================================================== --}}

    <div class="dashboard-card salary-card">

        <div class="dashboard-card-top">

            <div class="dashboard-card-icon">
                ₨
            </div>

            <span class="dashboard-card-status positive">
                {{ $monthName }}
            </span>

        </div>


        <div class="dashboard-card-content">

            <span class="dashboard-card-label">
                Teacher Salaries Paid
            </span>

            <h3>
                Rs. {{ number_format($teacherSalariesPaid, 2) }}
            </h3>

            <p>
                Salaries paid to teachers
            </p>

        </div>

    </div>


    {{-- =====================================================
         PENDING FEES
    ====================================================== --}}

    <div class="dashboard-card pending-card">

        <div class="dashboard-card-top">

            <div class="dashboard-card-icon">
                !
            </div>

            <span class="dashboard-card-status warning">
                Outstanding
            </span>

        </div>


        <div class="dashboard-card-content">

            <span class="dashboard-card-label">
                Pending Fees
            </span>

            <h3>
                Rs. {{ number_format($pendingFees, 2) }}
            </h3>

            <p>
                Fees still pending to collect
            </p>

        </div>

    </div>


    {{-- =====================================================
         PENDING SALARIES
    ====================================================== --}}

    <div class="dashboard-card salary-pending-card">

        <div class="dashboard-card-top">

            <div class="dashboard-card-icon">
                !
            </div>

            <span class="dashboard-card-status warning">
                Outstanding
            </span>

        </div>


        <div class="dashboard-card-content">

            <span class="dashboard-card-label">
                Pending Salaries
            </span>

            <h3>
                Rs. {{ number_format($teacherSalariesPending, 2) }}
            </h3>

            <p>
                Teacher salaries still pending
            </p>

        </div>

    </div>


    {{-- =====================================================
         MISCELLANEOUS EXPENSES
    ====================================================== --}}

    <div class="dashboard-card expense-card">

        <div class="dashboard-card-top">

            <div class="dashboard-card-icon">
                −
            </div>

            <span class="dashboard-card-status neutral">
                Expenses
            </span>

        </div>


        <div class="dashboard-card-content">

            <span class="dashboard-card-label">
                Miscellaneous Expenses
            </span>

            <h3>
                Rs. {{ number_format($miscellaneousCharges, 2) }}
            </h3>

            <p>
                Rent, electricity, tea and other expenses
            </p>

        </div>

    </div>


    {{-- =====================================================
         PROFIT / LOSS
    ====================================================== --}}

    <div class="dashboard-card profit-card">

        <div class="dashboard-card-top">

            <div class="dashboard-card-icon">
                ↗
            </div>

            <span
                class="dashboard-card-status
                {{ $profitLoss >= 0 ? 'positive' : 'warning' }}"
            >
                {{ $monthName }}
            </span>

        </div>


        <div class="dashboard-card-content">

            <span class="dashboard-card-label">
                Total Profit / Loss
            </span>

            <h3>
                Rs. {{ number_format($profitLoss, 2) }}
            </h3>

            <p>
                Monthly financial result
            </p>

        </div>

    </div>

</div>


{{-- =========================================================
     FEE DEFAULTERS
========================================================== --}}

<div class="dashboard-section-heading defaulter-heading">

    <div>

        <h2>
            Fee Defaulters
        </h2>

        <p>
            Students with outstanding fee payments
        </p>

    </div>


    <a
        href="{{ route('enrolled-students.index') }}"
        class="dashboard-view-all"
    >
        View All
        <span>→</span>
    </a>

</div>


{{-- =========================================================
     DEFAULTERS TABLE
========================================================== --}}

<div class="dashboard-table-card">


    {{-- Table Header --}}

    <div class="dashboard-table-header">

        <div>

            <strong>
                Outstanding Students
            </strong>

            <span>
                {{ $defaulters->count() }} students
            </span>

        </div>

    </div>


    {{-- =====================================================
         IF DEFAULTERS EXIST
    ====================================================== --}}

    @if($defaulters->count() > 0)

        <div class="dashboard-table-wrapper">

            <table class="dashboard-table">

                <thead>

                    <tr>

                        <th>
                            Student
                        </th>

                        <th>
                            Class
                        </th>

                        <th>
                            Board
                        </th>

                        <th>
                            Pending Fee
                        </th>

                    </tr>

                </thead>


                <tbody>
    @foreach($defaulters as $student)
        <tr>

            {{-- Student Name --}}
            <td>
                <div class="student-name-cell">

                    <div class="student-avatar">
                        {{ strtoupper(substr($student->name, 0, 1)) }}
                    </div>

                    <strong>
                        {{ $student->name }}
                    </strong>

                </div>
            </td>

            {{-- Class --}}
            <td>
                <span class="table-class">
                    {{ $student->class }}
                </span>
            </td>

            {{-- Board --}}
            <td>
                {{ $student->board }}
            </td>

            {{-- Pending Fee --}}
            <td>
                <strong class="pending-amount">
                    Rs.
                    {{ number_format($student->pending_amount, 2) }}
                </strong>
            </td>

        </tr>
    @endforeach
</tbody>

            </table>

        </div>


    {{-- =====================================================
         NO DEFAULTERS
    ====================================================== --}}

    @else

        <div class="dashboard-empty">

            <div class="dashboard-empty-icon">
                ✓
            </div>

            <h3>
                No fee defaulters
            </h3>

            <p>
                All students are currently up to date with their fees.
            </p>

        </div>

    @endif

</div>


</div>

@endsection
