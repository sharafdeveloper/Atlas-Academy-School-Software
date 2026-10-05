@extends('layouts.app')

@section('title', 'Teachers')

@section('content')

<div class="page-header">

    <div>
        <h1 class="page-title">Teachers</h1>

        <p class="page-subtitle">
            Manage academy teachers and their class charges
        </p>
    </div>

    <a href="{{ route('teachers.create') }}" class="primary-btn">
        + Add Teacher
    </a>

</div>


@if(session('success'))

    <div class="alert-success">
        {{ session('success') }}
    </div>

@endif


{{-- =========================
     STATISTICS
========================= --}}

<div class="stats-grid">

    <div class="stat-card">

        <div class="stat-content">

            <p>Total Teachers</p>

            <h2>
                {{ $teachers->count() }}
            </h2>

        </div>

        <div class="stat-icon">
            ◎
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-content">

            <p>Active</p>

            <h2>
                {{ $teachers->where('status', 'Active')->count() }}
            </h2>

        </div>

        <div class="stat-icon">
            ✓
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-content">

            <p>Inactive</p>

            <h2>
                {{ $teachers->where('status', 'Inactive')->count() }}
            </h2>

        </div>

        <div class="stat-icon">
            !
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-content">

            <p>Weekly Classes</p>

            <h2>
                {{ $teachers->sum('weekly_classes') }}
            </h2>

        </div>

        <div class="stat-icon">
            ⏱
        </div>

    </div>

</div>


{{-- =========================
     FILTERS
========================= --}}

<div class="content-card filter-card">

    <div class="card-header">

        <div>

            <h2>Filter Teachers</h2>

            <p>
                Search teachers by name or filter by status
            </p>

        </div>

    </div>


    <form method="GET" action="{{ route('teachers.index') }}">

        <div class="filter-grid">


            {{-- Search --}}

            <div class="form-group">

                <label for="search">
                    Search
                </label>

                <input
                    type="text"
                    name="search"
                    id="search"
                    class="form-control"
                    value="{{ request('search') }}"
                    placeholder="Search teacher..."
                >

            </div>


            {{-- Status --}}

            <div class="form-group">

                <label for="status">
                    Status
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
                        value="Active"
                        {{ request('status') == 'Active' ? 'selected' : '' }}
                    >
                        Active
                    </option>

                    <option
                        value="Inactive"
                        {{ request('status') == 'Inactive' ? 'selected' : '' }}
                    >
                        Inactive
                    </option>

                </select>

            </div>


            {{-- Search Button --}}

            <div class="form-group">

                <label>&nbsp;</label>

                <button type="submit" class="save-btn">
                    Search
                </button>

            </div>


        </div>

    </form>

</div>


{{-- =========================
     TEACHERS TABLE
========================= --}}

<div class="content-card students-table-card">

    <div class="card-header">

        <div>

            <h2>All Teachers</h2>

            <p>
                Complete list of academy teachers
            </p>

        </div>

    </div>


    <div class="table-wrapper">

        <table class="premium-table">

            <thead>

                <tr>

                    <th>Teacher</th>

                    <th>Weekly Classes</th>

                    <th>Per Class</th>

                    <th>Est. Monthly Salary</th>

                    <th>Status</th>

                    <th>Actions</th>

                </tr>

            </thead>


            <tbody>

                @forelse($teachers as $teacher)

                    @php
                        $monthlySalary =
                            $teacher->weekly_classes *
                            $teacher->per_class_charge *
                            4;
                    @endphp

                    <tr>


                        {{-- Teacher --}}

                        <td>

                            <div class="student-info">

                                <div class="student-avatar">

                                    {{ strtoupper(substr($teacher->name, 0, 1)) }}

                                </div>

                                <div>

                                    <strong>
                                        {{ $teacher->name }}
                                    </strong>

                                    @if($teacher->phone_number)

                                        <span>
                                            {{ $teacher->phone_number }}
                                        </span>

                                    @endif

                                </div>

                            </div>

                        </td>


                        {{-- Weekly Classes --}}

                        <td>
                            {{ $teacher->weekly_classes }}
                        </td>


                        {{-- Per Class --}}

                        <td>
                            Rs. {{ number_format($teacher->per_class_charge, 0) }}
                        </td>


                        {{-- Est. Monthly Salary --}}

                        <td>
                            <strong>
                                Rs. {{ number_format($monthlySalary, 0) }}
                            </strong>
                        </td>


                        {{-- Status --}}

                        <td>

                            @if($teacher->status === 'Active')

                                <span class="status-badge status-joined">
                                    Active
                                </span>

                            @else

                                <span class="status-badge status-not-interested">
                                    Inactive
                                </span>

                            @endif

                        </td>


                        {{-- Actions --}}

                        <td>

                            <div class="action-buttons">


                                {{-- View --}}

                                <a
                                    href="{{ route('teachers.show', $teacher->id) }}"
                                    class="action-btn view-btn"
                                >
                                    View
                                </a>


                                {{-- Edit --}}

                                <a
                                    href="{{ route('teachers.edit', $teacher->id) }}"
                                    class="action-btn edit-btn"
                                >
                                    Edit
                                </a>


                                {{-- Delete --}}

                                <form
                                    action="{{ route('teachers.destroy', $teacher->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this teacher?');"
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

                        <td colspan="6">

                            <div class="empty-state">

                                <div class="empty-icon">
                                    ◎
                                </div>

                                <h3>
                                    No teachers found
                                </h3>

                                <p>
                                    No teachers match your selected filters.
                                </p>

                                <a
                                    href="{{ route('teachers.create') }}"
                                    class="primary-btn"
                                >
                                    + Add Teacher
                                </a>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection