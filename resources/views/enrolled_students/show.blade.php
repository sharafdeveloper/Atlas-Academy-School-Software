@extends('layouts.app')

@section('title', 'Student Details')

@section('content')

<div class="page-header">

    <div>
        <h1 class="page-title">Student Details</h1>

        <p class="page-subtitle">
            View complete information about this enrolled student
        </p>
    </div>

    <div class="page-header-actions">

        <a
            href="{{ route('enrolled-students.edit', $enrolledStudent->id) }}"
            class="secondary-btn"
        >
            Edit Student
        </a>

        <a
            href="{{ route('enrolled-students.index') }}"
            class="secondary-btn"
        >
            ← Back
        </a>

    </div>

</div>


<div class="student-profile-card">


{{-- =========================================================
     PROFILE HEADER
========================================================= --}}

<div class="student-profile-header">

    <div class="student-avatar">
        {{ strtoupper(substr($enrolledStudent->name, 0, 1)) }}
    </div>

    <div class="student-profile-info">

        <h2>
            {{ $enrolledStudent->name }}
        </h2>

        <p>
            Enrolled Student
        </p>

    </div>


    {{-- Fee Status --}}

    @if(strtolower(trim($enrolledStudent->fee_status)) === 'paid')

        <div class="profile-fee-status paid">

            <span>✓</span>

            Paid

        </div>

    @else

        <div class="profile-fee-status defaulter">

            <span>!</span>

            Fee Defaulter

        </div>

    @endif

</div>



{{-- =========================================================
     STUDENT INFORMATION
========================================================= --}}

<div class="details-section">

    <div class="details-section-title">

        <div class="details-icon">
            👤
        </div>

        <div>

            <h3>Student Information</h3>

            <p>
                Basic academic and personal information
            </p>

        </div>

    </div>


    <div class="details-grid">


        {{-- Student Code --}}

        <div class="detail-item">

            <span class="detail-label">
                Student Code
            </span>

            <strong class="detail-value">
                {{ $enrolledStudent->student_code ?? '—' }}
            </strong>

        </div>


        {{-- Student Name --}}

        <div class="detail-item">

            <span class="detail-label">
                Student Name
            </span>

            <strong class="detail-value">
                {{ $enrolledStudent->name }}
            </strong>

        </div>


        {{-- Father Name --}}

        <div class="detail-item">

            <span class="detail-label">
                Father Name
            </span>

            <strong class="detail-value">
                {{ $enrolledStudent->father_name ?? '—' }}
            </strong>

        </div>


        {{-- Class --}}

        <div class="detail-item">

            <span class="detail-label">
                Class
            </span>

            <strong class="detail-value">
                {{ $enrolledStudent->class }}
            </strong>

        </div>


        {{-- Board --}}

        <div class="detail-item">

            <span class="detail-label">
                Board
            </span>

            <strong class="detail-value">
                {{ $enrolledStudent->board }}
            </strong>

        </div>


        {{-- Date of Admission --}}

        <div class="detail-item">

            <span class="detail-label">
                Date of Admission
            </span>

            <strong class="detail-value">

                @if($enrolledStudent->date_of_admission)

                    {{ \Carbon\Carbon::parse($enrolledStudent->date_of_admission)->format('d M Y') }}

                @else

                    —

                @endif

            </strong>

        </div>

    </div>

</div>



{{-- =========================================================
     SUBJECT INFORMATION
========================================================= --}}

@php

    $studentSubjects = is_array($enrolledStudent->subjects)
        ? $enrolledStudent->subjects
        : json_decode($enrolledStudent->subjects ?? '[]', true);

    if (!is_array($studentSubjects)) {
        $studentSubjects = [];
    }

@endphp


<div class="details-section">

    <div class="details-section-title">

        <div class="details-icon">
            📚
        </div>

        <div>

            <h3>Subjects</h3>

            <p>
                Subjects currently selected for this student
            </p>

        </div>

    </div>


    <div class="details-grid">


        {{-- Subjects Count --}}

        <div class="detail-item">

            <span class="detail-label">
                Total Subjects
            </span>

            <strong class="detail-value">
                {{ count($studentSubjects) }}
            </strong>

        </div>


        {{-- Subjects --}}

        <div class="detail-item">

            <span class="detail-label">
                Selected Subjects
            </span>

            <strong class="detail-value">

                @if(count($studentSubjects) > 0)

                    {{ implode(', ', $studentSubjects) }}

                @else

                    —

                @endif

            </strong>

        </div>

    </div>

</div>



{{-- =========================================================
     CONTACT INFORMATION
========================================================= --}}

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


        {{-- Phone Number --}}

        <div class="detail-item">

            <span class="detail-label">
                Phone Number
            </span>

            <strong class="detail-value">
                {{ $enrolledStudent->phone_number ?: 'Not provided' }}
            </strong>

        </div>


        {{-- WhatsApp Number --}}

        <div class="detail-item">

            <span class="detail-label">
                WhatsApp Number
            </span>

            <strong class="detail-value">
                {{ $enrolledStudent->whatsapp_number ?: 'Not provided' }}
            </strong>

        </div>

    </div>

</div>



{{-- =========================================================
     FEE INFORMATION
========================================================= --}}

<div class="details-section">

    <div class="details-section-title">

        <div class="details-icon">
            ₨
        </div>

        <div>

            <h3>Fee Information</h3>

            <p>
                Current academy fee information
            </p>

        </div>

    </div>


    <div class="details-grid">


        {{-- Admission Fee --}}

        <div class="detail-item">

            <span class="detail-label">
                Admission Fee
            </span>

            <strong class="detail-value">
                Rs. {{ number_format($enrolledStudent->admission_fee ?? 0, 2) }}
            </strong>

        </div>


        {{-- Base Monthly Fee --}}

        <div class="detail-item">

            <span class="detail-label">
                Base Monthly Fee
            </span>

            <strong class="detail-value">
                Rs. {{ number_format($enrolledStudent->base_fee ?? 0, 2) }}
            </strong>

        </div>


        {{-- Discount --}}

        <div class="detail-item">

            <span class="detail-label">
                Discount
            </span>

            <strong class="detail-value">
                Rs. {{ number_format($enrolledStudent->discount ?? 0, 2) }}
            </strong>

        </div>


        {{-- Final Monthly Fee --}}

        <div class="detail-item">

            <span class="detail-label">
                Monthly Fee
            </span>

            <strong class="fee-amount">
                Rs. {{ number_format($enrolledStudent->fees ?? 0, 2) }}
            </strong>

        </div>


        {{-- Fee Status --}}

        <div class="detail-item">

            <span class="detail-label">
                Fee Status
            </span>


            @if(strtolower(trim($enrolledStudent->fee_status)) === 'paid')

                <span class="detail-status paid">
                    ✓ Paid
                </span>

            @else

                <span class="detail-status defaulter">
                    ! Fee Defaulter
                </span>

            @endif

        </div>

    </div>

</div>



{{-- =========================================================
     ACTIONS
========================================================= --}}

<div class="student-actions">


    @if(strtolower(trim($enrolledStudent->fee_status)) !== 'paid')

        <a
            href="{{ route('fee-payments.create', $enrolledStudent->id) }}"
            class="pay-fee-btn"
        >
            ✓ Pay Fee
        </a>

    @else

        <div class="already-paid">
            ✓ Fee Paid
        </div>

    @endif


    <a
        href="{{ route('enrolled-students.edit', $enrolledStudent->id) }}"
        class="edit-student-btn"
    >
        Edit Student
    </a>

</div>


</div>

@endsection