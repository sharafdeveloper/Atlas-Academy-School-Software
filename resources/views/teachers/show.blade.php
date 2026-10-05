@extends('layouts.app')

@section('title', 'Teacher Details')

@section('content')

<div class="page-header">

    <div>
        <h1 class="page-title">Teacher Details</h1>

        <p class="page-subtitle">
            View complete teacher information and salary details
        </p>
    </div>

    <div class="page-header-actions">

        <a
            href="{{ route('teachers.edit', $teacher->id) }}"
            class="secondary-btn"
        >
            ✎ Edit Teacher
        </a>

        <a
            href="{{ route('teachers.index') }}"
            class="secondary-btn"
        >
            ← Back
        </a>

    </div>

</div>


<div class="student-profile-card">

    {{-- PROFILE HEADER --}}

    <div class="student-profile-header">

        <div class="student-avatar">
            {{ strtoupper(substr($teacher->name, 0, 1)) }}
        </div>

        <div class="student-profile-info">

            <h2>
                {{ $teacher->name }}
            </h2>

            <p>
                Teacher ID: #{{ $teacher->id }}
            </p>

        </div>


        {{-- Status --}}

        @if($teacher->status === 'Active')

            <div class="profile-fee-status paid">
                <span>●</span>
                Active
            </div>

        @else

            <div class="profile-fee-status defaulter">
                <span>●</span>
                Inactive
            </div>

        @endif

    </div>


    {{-- TEACHER INFORMATION --}}

    <div class="details-section">

        <div class="details-section-title">

            <div class="details-icon">
                👤
            </div>

            <div>
                <h3>Teacher Information</h3>

                <p>
                    Basic teacher information
                </p>
            </div>

        </div>


        <div class="details-grid">

            <div class="detail-item">

                <span class="detail-label">
                    Teacher Name
                </span>

                <strong>
                    {{ $teacher->name }}
                </strong>

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    Phone Number
                </span>

                <strong>
                    {{ $teacher->phone_number ?: 'Not provided' }}
                </strong>

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    WhatsApp Number
                </span>

                <strong>
                    {{ $teacher->whatsapp_number ?: 'Not provided' }}
                </strong>

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    Joining Date
                </span>

                <strong>
                    @if($teacher->joining_date)
                        {{ \Carbon\Carbon::parse($teacher->joining_date)->format('d F Y') }}
                    @else
                        Not provided
                    @endif
                </strong>

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    Added On
                </span>

                <strong>
                    {{ $teacher->created_at->format('d F Y') }}
                </strong>

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    Current Status
                </span>

                <strong>
                    {{ $teacher->status }}
                </strong>

            </div>

        </div>

    </div>


    {{-- SALARY SUMMARY --}}

    <div class="details-section">

        <div class="details-section-title">

            <div class="details-icon">
                ₨
            </div>

            <div>
                <h3>Salary Summary</h3>

                <p>
                    Weekly classes and payment rate
                </p>
            </div>

        </div>


        <div class="details-grid">

            <div class="detail-item">

                <span class="detail-label">
                    Classes Per Week
                </span>

                <strong>
                    {{ number_format($teacher->weekly_classes) }}
                </strong>

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    Per Class Charge
                </span>

                <strong>
                    Rs. {{ number_format($teacher->per_class_charge, 2) }}
                </strong>

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    Estimated Monthly Salary
                </span>

                <strong class="fee-amount">
                    Rs.
                    {{ number_format(
                        ($teacher->weekly_classes * $teacher->per_class_charge) * 4,
                        2
                    ) }}
                </strong>

            </div>

        </div>

    </div>


</div>

@endsection