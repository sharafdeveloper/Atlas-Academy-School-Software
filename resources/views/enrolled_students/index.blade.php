@extends('layouts.app')

@section('title', 'Enrolled Students')

@section('content')

<div class="page-header">

    <div>
        <h1 class="page-title">
            Enrolled Students
        </h1>

        <p class="page-subtitle">
            Manage and monitor all enrolled students
        </p>
    </div>

    <a
        href="{{ route('enrolled-students.create') }}"
        class="primary-btn"
    >
        + Add Student
    </a>

</div>


{{-- =========================================================
     MONTH FILTER
========================================================= --}}

<div style="margin: 20px 0;">

    <form
        method="GET"
        action="{{ route('enrolled-students.index') }}"
    >

        {{-- Preserve existing filters --}}
        <input
            type="hidden"
            name="class"
            value="{{ request('class') }}"
        >

        <input
            type="hidden"
            name="board"
            value="{{ request('board') }}"
        >

        <input
            type="hidden"
            name="status"
            value="{{ request('status') }}"
        >

        <label
            for="month"
            style="font-weight: 600; margin-right: 10px;"
        >
            Month:
        </label>

        <select
            name="month"
            id="month"
            class="form-control"
            onchange="this.form.submit()"
            style="display: inline-block; width: 220px;"
        >

            @foreach($availableMonths as $month)

                <option
                    value="{{ $month['value'] }}"
                    {{ $selectedMonth == $month['value'] ? 'selected' : '' }}
                >
                    {{ $month['label'] }}
                </option>

            @endforeach

        </select>

    </form>

</div>


{{-- =========================================================
     STATISTICS
========================================================= --}}

<div class="stats-grid">

    {{-- Total Students --}}
    <div class="stat-card">

        <div class="stat-content">

            <p>
                Total Students
            </p>

            <h2>
                {{ $totalStudents }}
            </h2>

        </div>

        <div class="stat-icon">
            ◎
        </div>

    </div>


    {{-- IX Students --}}
    <div class="stat-card">

        <div class="stat-content">

            <p>
                IX Students
            </p>

            <h2>
                {{ $students->where('class', 'IX')->count() }}
            </h2>

        </div>

        <div class="stat-icon">
            IX
        </div>

    </div>


    {{-- X Students --}}
    <div class="stat-card">

        <div class="stat-content">

            <p>
                X Students
            </p>

            <h2>
                {{ $students->where('class', 'X')->count() }}
            </h2>

        </div>

        <div class="stat-icon">
            X
        </div>

    </div>


    {{-- Fee Defaulters --}}
    <div class="stat-card">

        <div class="stat-content">

            <p>
                Fee Defaulters
            </p>

            <h2>
                {{ $feeDefaulters }}
            </h2>

        </div>

        <div class="stat-icon">
            !
        </div>

    </div>

</div>


{{-- =========================================================
     FILTERS
========================================================= --}}

<div class="content-card filter-card">

    <div class="card-header">

        <div>

            <h2>
                Filter Students
            </h2>

            <p>
                Filter enrolled students by class, board or fee status
            </p>

        </div>

    </div>


    <form
        method="GET"
        action="{{ route('enrolled-students.index') }}"
    >

        {{-- Preserve selected month --}}
        <input
            type="hidden"
            name="month"
            value="{{ $selectedMonth }}"
        >


        <div class="filter-grid">


            {{-- =================================================
                 CLASS
            ================================================= --}}

            <div class="form-group">

                <label for="class">
                    Class
                </label>

                <select
                    name="class"
                    id="class"
                    class="form-control"
                    onchange="this.form.submit()"
                >

                    <option value="">
                        All Classes
                    </option>

                    <option
                        value="IX"
                        {{ request('class') == 'IX' ? 'selected' : '' }}
                    >
                        IX
                    </option>

                    <option
                        value="X"
                        {{ request('class') == 'X' ? 'selected' : '' }}
                    >
                        X
                    </option>

                    <option
                        value="XI"
                        {{ request('class') == 'XI' ? 'selected' : '' }}
                    >
                        XI
                    </option>

                    <option
                        value="XII"
                        {{ request('class') == 'XII' ? 'selected' : '' }}
                    >
                        XII
                    </option>

                </select>

            </div>


            {{-- =================================================
                 BOARD
            ================================================= --}}

            <div class="form-group">

                <label for="board">
                    Board
                </label>

                <select
                    name="board"
                    id="board"
                    class="form-control"
                    onchange="this.form.submit()"
                >

                    <option value="">
                        All Boards
                    </option>

                    <option
                        value="Federal Board"
                        {{ request('board') == 'Federal Board' ? 'selected' : '' }}
                    >
                        Federal Board
                    </option>

                    <option
                        value="Karachi Board"
                        {{ request('board') == 'Karachi Board' ? 'selected' : '' }}
                    >
                        Karachi Board
                    </option>

                </select>

            </div>


            {{-- =================================================
                 FEE STATUS
            ================================================= --}}

            <div class="form-group">

                <label for="status">
                    Fee Status
                </label>

                <select
                    name="status"
                    id="status"
                    class="form-control"
                    onchange="this.form.submit()"
                >

                    <option value="">
                        All Status
                    </option>

                    <option
                        value="Paid"
                        {{ request('status') == 'Paid' ? 'selected' : '' }}
                    >
                        Paid
                    </option>

                    <option
                        value="Fee Defaulter"
                        {{ request('status') == 'Fee Defaulter' ? 'selected' : '' }}
                    >
                        Fee Defaulter
                    </option>

                </select>

            </div>

        </div>

    </form>

</div>


{{-- =========================================================
     STUDENTS TABLE
========================================================= --}}

<div class="content-card students-table-card">

    <div class="card-header">

        <div>

            <h2>
                All Enrolled Students
            </h2>

            <p>
                Complete list of students currently enrolled
            </p>

        </div>

    </div>


    <div class="table-wrapper">

        <table class="premium-table">

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
                        Phone
                    </th>

                    <th>
                        WhatsApp
                    </th>

                    <th>
                        Fees
                    </th>

                    <th>
                        Fee Status
                    </th>

                    <th>
                        Student Status
                    </th>

                    <th>
                        Actions
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($students as $student)

                    <tr>


                        {{-- =================================================
                             STUDENT
                        ================================================= --}}

                        <td>

                            <div class="student-info">

                                <div class="student-avatar">

                                    {{ strtoupper(substr($student->name, 0, 1)) }}

                                </div>


                                <div>

                                    <strong>
                                        {{ $student->name }}
                                    </strong>

                                    <span>
                                        Student #{{ $student->id }}
                                    </span>

                                </div>

                            </div>

                        </td>


                        {{-- =================================================
                             CLASS
                        ================================================= --}}

                        <td>

                            <span class="class-badge">

                                {{ $student->class }}

                            </span>

                        </td>


                        {{-- =================================================
                             BOARD
                        ================================================= --}}

                        <td>

                            {{ $student->board }}

                        </td>


                        {{-- =================================================
                             PHONE
                        ================================================= --}}

                        <td>

                            {{ $student->phone_number }}

                        </td>


                        {{-- =================================================
                             WHATSAPP
                        ================================================= --}}

                        <td>

                            {{ $student->whatsapp_number }}

                        </td>


                        {{-- =================================================
                             FEES
                        ================================================= --}}

                        <td>

                            <strong>
                                Rs. {{ number_format($student->fees) }}
                            </strong>

                        </td>


                        {{-- =================================================
                             MONTHLY FEE STATUS
                        ================================================= --}}

                        <td>

                            @if($student->monthly_fee_status === 'Paid')

                                <span class="status-badge status-joined">
                                    Paid
                                </span>

                            @else

                                <span class="status-badge status-not-interested">
                                    Fee Defaulter
                                </span>

                            @endif

                        </td>


                        {{-- =================================================
                             STUDENT STATUS
                        ================================================= --}}

                        <td>

                            @if($student->status === 'Active')

                                <span class="status-badge status-joined">
                                    Active
                                </span>

                            @else

                                <span class="status-badge status-not-interested">
                                    Inactive
                                </span>

                            @endif

                        </td>


                        {{-- =================================================
                             ACTIONS
                        ================================================= --}}

                        <td>

                            <div class="action-buttons">


                                {{-- =================================================
                                     VIEW
                                ================================================= --}}

                                <a
                                    href="{{ route('enrolled-students.show', $student->id) }}"
                                    class="action-btn view-btn"
                                >
                                    View
                                </a>


                                {{-- =================================================
                                     EDIT
                                ================================================= --}}

                                <a
                                    href="{{ route('enrolled-students.edit', $student->id) }}"
                                    class="action-btn edit-btn"
                                >
                                    Edit
                                </a>


                                {{-- =================================================
                                     PAY FEE
                                ================================================= --}}

                                @if($student->monthly_fee_status !== 'Paid')

                                    <a
                                        href="{{ route('fee-payments.create', $student->id) }}"
                                        class="action-btn pay-btn"
                                    >
                                        Pay Fee
                                    </a>

                                @endif


                                {{-- =================================================
                                     PRINT
                                ================================================= --}}

                                @if($student->feePayments->isNotEmpty())

                                    <a
                                        href="{{ route('fee-payments.show', $student->feePayments->first()->id) }}"
                                        class="action-btn print-action"
                                    >
                                        🖨 Print
                                    </a>

                                @endif


                                {{-- =================================================
                                     DELETE
                                ================================================= --}}

                                <form
                                    action="{{ route('enrolled-students.destroy', $student->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this student?');"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="action-btn delete-btn"
                                    >
                                        Delete
                                    </button>

                                </form>


                            </div>

                        </td>


                    </tr>


                @empty

                    <tr>

                        <td colspan="9">

                            <div class="empty-state">

                                <div class="empty-icon">
                                    ◎
                                </div>

                                <h3>
                                    No students found
                                </h3>

                                <p>
                                    No enrolled students match your selected filters.
                                </p>

                                <a
                                    href="{{ route('enrolled-students.create') }}"
                                    class="primary-btn"
                                >
                                    + Add Student
                                </a>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


{{-- =========================================================
     PAGINATION
========================================================= --}}

@if($students->hasPages())

    <div style="margin-top: 20px;">

        {{ $students->links() }}

    </div>

@endif

@endsection