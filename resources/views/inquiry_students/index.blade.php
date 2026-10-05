@extends('layouts.app')

@section('title', 'Inquiry Students')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Inquiry Students</h1>
        <p class="page-subtitle">
            Manage and track all student inquiries
        </p>
    </div>

    <a href="{{ route('inquiry-students.create') }}" class="primary-btn">
        + Add Inquiry
    </a>
</div>


<!-- Statistics -->

<div class="stats-grid">

    <div class="stat-card">
        <div class="stat-content">
            <p>Total Inquiries</p>
            <h2>{{ $inquiries->count() }}</h2>
        </div>

        <div class="stat-icon">
            ◎
        </div>
    </div>


    <div class="stat-card">
        <div class="stat-content">
            <p>New</p>
            <h2>
                {{ $inquiries->where('status', 'New')->count() }}
            </h2>
        </div>

        <div class="stat-icon">
            +
        </div>
    </div>


    <div class="stat-card">
        <div class="stat-content">
            <p>Contacted</p>
            <h2>
                {{ $inquiries->where('status', 'Contacted')->count() }}
            </h2>
        </div>

        <div class="stat-icon">
            ◉
        </div>
    </div>


    <div class="stat-card">
        <div class="stat-content">
            <p>Joined</p>
            <h2>
                {{ $inquiries->where('status', 'Joined')->count() }}
            </h2>
        </div>

        <div class="stat-icon">
            ✓
        </div>
    </div>

</div>


<!-- Inquiry Table Card -->

<div class="content-card">

    <div class="card-header">

        <div>
            <h2>All Inquiries</h2>

            <p>
                Complete list of student inquiries
            </p>
        </div>

    </div>


    <div class="table-wrapper">

        <table class="premium-table">

            <thead>

                <tr>
                    <th>Student</th>
                    <th>Class</th>
                    <th>Board</th>
                    <th>Phone</th>
                    <th>Course</th>
                    <th>Inquiry Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>

            </thead>


            <tbody>

                @forelse($inquiries as $inquiry)

                    <tr>

                        <td>
                            <div class="student-info">

                                <div class="student-avatar">
                                    {{ strtoupper(substr($inquiry->name, 0, 1)) }}
                                </div>

                                <div>
                                    <strong>
                                        {{ $inquiry->name }}
                                    </strong>

                                    <span>
                                        Inquiry #{{ $inquiry->id }}
                                    </span>
                                </div>

                            </div>
                        </td>


                        <td>
                            <span class="class-badge">
                                {{ $inquiry->class }}
                            </span>
                        </td>


                        <td>
                            {{ $inquiry->board }}
                        </td>


                        <td>
                            {{ $inquiry->phone_number }}
                        </td>


                        <td>
                            {{ $inquiry->interested_course }}
                        </td>


                        <td>
                            {{ \Carbon\Carbon::parse($inquiry->inquiry_date)->format('d M Y') }}
                        </td>


                        <td>

                            @if($inquiry->status === 'New')

                                <span class="status-badge status-new">
                                    New
                                </span>

                            @elseif($inquiry->status === 'Contacted')

                                <span class="status-badge status-contacted">
                                    Contacted
                                </span>

                            @elseif($inquiry->status === 'Joined')

                                <span class="status-badge status-joined">
                                    Joined
                                </span>

                            @else

                                <span class="status-badge status-not-interested">
                                    Not Interested
                                </span>

                            @endif

                        </td>


                        <td>

                            <div class="action-buttons">

                                <a
                                    href="{{ route('inquiry-students.show', $inquiry->id) }}"
                                    class="action-btn view-btn"
                                >
                                    View
                                </a>


                                <a
                                    href="{{ route('inquiry-students.edit', $inquiry->id) }}"
                                    class="action-btn edit-btn"
                                >
                                    Edit
                                </a>


                                <form
                                    action="{{ route('inquiry-students.destroy', $inquiry->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this inquiry?');"
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

                        <td colspan="8">

                            <div class="empty-state">

                                <div class="empty-icon">
                                    ◎
                                </div>

                                <h3>No inquiries found</h3>

                                <p>
                                    Start by adding your first inquiry student.
                                </p>

                                <a
                                    href="{{ route('inquiry-students.create') }}"
                                    class="primary-btn"
                                >
                                    + Add Inquiry
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