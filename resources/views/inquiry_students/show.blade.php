@extends('layouts.app')

@section('title', 'Inquiry Details')

@section('content')

<div class="page-header">

    <div>
        <h1 class="page-title">Inquiry Details</h1>

        <p class="page-subtitle">
            View complete information about this student inquiry
        </p>
    </div>

    <div class="page-header-actions">

        <a
            href="{{ route('inquiry-students.edit', $inquiryStudent->id) }}"
            class="secondary-btn"
        >
            Edit Inquiry
        </a>

        <a
            href="{{ route('inquiry-students.index') }}"
            class="secondary-btn"
        >
            ← Back
        </a>

    </div>

</div>


<div class="student-profile-card">

    {{-- =========================
         PROFILE HEADER
    ========================== --}}

    <div class="student-profile-header">

        <div class="student-avatar">
            {{ strtoupper(substr($inquiryStudent->name, 0, 1)) }}
        </div>

        <div class="student-profile-info">

            <h2>
                {{ $inquiryStudent->name }}
            </h2>

            <p>
                Student Inquiry
            </p>

        </div>


        {{-- Inquiry Status --}}

        @php
            $status = strtolower(trim($inquiryStudent->status));
        @endphp


        @if($status === 'new')

            <div class="profile-fee-status">
                <span>●</span>
                New
            </div>

        @elseif($status === 'follow up')

            <div class="profile-fee-status defaulter">
                <span>↻</span>
                Follow Up
            </div>

        @elseif($status === 'joined')

            <div class="profile-fee-status paid">
                <span>✓</span>
                Joined
            </div>

        @else

            <div class="profile-fee-status defaulter">
                <span>×</span>
                Not Interested
            </div>

        @endif

    </div>


    {{-- =========================
         STUDENT INFORMATION
    ========================== --}}

    <div class="details-section">

        <div class="details-section-title">

            <div class="details-icon">
                👤
            </div>

            <div>

                <h3>Student Information</h3>

                <p>
                    Basic academic information
                </p>

            </div>

        </div>


        <div class="details-grid">

            <div class="detail-item">

                <span class="detail-label">
                    Student Name
                </span>

                <strong>
                    {{ $inquiryStudent->name }}
                </strong>

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    Class
                </span>

                <strong>
                    {{ $inquiryStudent->class }}
                </strong>

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    Board
                </span>

                <strong>
                    {{ $inquiryStudent->board }}
                </strong>

            </div>

        </div>

    </div>


    {{-- =========================
         CONTACT INFORMATION
    ========================== --}}

    <div class="details-section">

        <div class="details-section-title">

            <div class="details-icon">
                ☎
            </div>

            <div>

                <h3>Contact Information</h3>

                <p>
                    Student or guardian contact details
                </p>

            </div>

        </div>


        <div class="details-grid">

            <div class="detail-item">

                <span class="detail-label">
                    Phone Number
                </span>

                <strong>
                    {{ $inquiryStudent->phone_number ?: 'Not provided' }}
                </strong>

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    WhatsApp Number
                </span>

                <strong>
                    {{ $inquiryStudent->whatsapp_number ?: 'Not provided' }}
                </strong>

            </div>

        </div>

    </div>


    {{-- =========================
         INQUIRY INFORMATION
    ========================== --}}

    <div class="details-section">

        <div class="details-section-title">

            <div class="details-icon">
                📝
            </div>

            <div>

                <h3>Inquiry Information</h3>

                <p>
                    Current inquiry status and notes
                </p>

            </div>

        </div>


        <div class="details-grid">

            <div class="detail-item">

                <span class="detail-label">
                    Inquiry Status
                </span>


                @if($status === 'new')

                    <span class="detail-status">
                        ● New
                    </span>

                @elseif($status === 'follow up')

                    <span class="detail-status defaulter">
                        ↻ Follow Up
                    </span>

                @elseif($status === 'joined')

                    <span class="detail-status paid">
                        ✓ Joined
                    </span>

                @else

                    <span class="detail-status defaulter">
                        × Not Interested
                    </span>

                @endif

            </div>


            <div class="detail-item">

                <span class="detail-label">
                    Notes
                </span>

                <strong>
                    {{ $inquiryStudent->notes ?: 'No notes added' }}
                </strong>

            </div>

        </div>

    </div>


    {{-- =========================
         ACTIONS
    ========================== --}}

    <div class="student-actions">

        <a
            href="{{ route('inquiry-students.edit', $inquiryStudent->id) }}"
            class="edit-student-btn"
        >
            Edit Inquiry
        </a>

        <a
            href="{{ route('inquiry-students.index') }}"
            class="secondary-btn"
        >
            Back to Inquiries
        </a>

    </div>

</div>

@endsection