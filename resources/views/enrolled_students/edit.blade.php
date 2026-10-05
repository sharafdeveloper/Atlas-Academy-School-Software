@extends('layouts.app')

@section('title', 'Edit Enrolled Student')

@section('content')

<div class="page-header">

    <div>
        <h1 class="page-title">Edit Enrolled Student</h1>

        <p class="page-subtitle">
            Update student information and fee details
        </p>
    </div>

    <a href="{{ route('enrolled-students.index') }}" class="secondary-btn">
        ← Back to Students
    </a>

</div>


<div class="form-card">

<form
    action="{{ route('enrolled-students.update', $enrolledStudent->id) }}"
    method="POST"
>

@csrf
@method('PUT')


{{-- =========================================================
     STUDENT INFORMATION
========================================================= --}}

<div class="form-section">

    <div class="form-section-header">

        <div class="section-icon">
            👤
        </div>

        <div>
            <h2>Student Information</h2>

            <p>
                Update the basic information of the student
            </p>
        </div>

    </div>


    <div class="form-grid">


        {{-- Student Code --}}
        <div class="form-group">

            <label for="student_code">
                Student Code
            </label>

            <input
                type="text"
                id="student_code"
                class="form-input"
                value="{{ $enrolledStudent->student_code }}"
                readonly
            >

            <small class="form-hint">
                Student code is automatically generated.
            </small>

        </div>


        {{-- Student Name --}}
        <div class="form-group">

            <label for="name">
                Student Name
                <span>*</span>
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $enrolledStudent->name) }}"
                placeholder="Enter student name"
                class="form-input"
                required
            >

            @error('name')
                <small class="form-error">
                    {{ $message }}
                </small>
            @enderror

        </div>


        {{-- Father Name --}}
        <div class="form-group">

            <label for="father_name">
                Father Name
                <span>*</span>
            </label>

            <input
                type="text"
                id="father_name"
                name="father_name"
                value="{{ old('father_name', $enrolledStudent->father_name) }}"
                placeholder="Enter father's name"
                class="form-input"
                required
            >

            @error('father_name')
                <small class="form-error">
                    {{ $message }}
                </small>
            @enderror

        </div>


        {{-- Class --}}
        <div class="form-group">

            <label for="class">
                Class
                <span>*</span>
            </label>

            <select
                id="class"
                name="class"
                class="form-input"
                required
            >

                <option value="">
                    Select Class
                </option>

                @foreach(['IX', 'X', 'XI', 'XII'] as $class)

                    <option
                        value="{{ $class }}"
                        {{ old('class', $enrolledStudent->class) == $class ? 'selected' : '' }}
                    >
                        {{ $class }}
                    </option>

                @endforeach

            </select>

            @error('class')
                <small class="form-error">
                    {{ $message }}
                </small>
            @enderror

        </div>


        {{-- Board --}}
        <div class="form-group">

            <label for="board">
                Board
                <span>*</span>
            </label>

            <select
                id="board"
                name="board"
                class="form-input"
                required
            >

                <option value="">
                    Select Board
                </option>

                <option
                    value="Federal Board"
                    {{ old('board', $enrolledStudent->board) == 'Federal Board' ? 'selected' : '' }}
                >
                    Federal Board
                </option>

                <option
                    value="Karachi Board"
                    {{ old('board', $enrolledStudent->board) == 'Karachi Board' ? 'selected' : '' }}
                >
                    Karachi Board
                </option>

            </select>

            @error('board')
                <small class="form-error">
                    {{ $message }}
                </small>
            @enderror

        </div>


        {{-- Date of Admission --}}
        <div class="form-group">

            <label for="date_of_admission">
                Date of Admission
                <span>*</span>
            </label>

            <input
                type="date"
                id="date_of_admission"
                name="date_of_admission"
                value="{{ old('date_of_admission', $enrolledStudent->date_of_admission) }}"
                class="form-input"
                required
            >

            @error('date_of_admission')
                <small class="form-error">
                    {{ $message }}
                </small>
            @enderror

        </div>

    </div>

</div>



{{-- =========================================================
     SUBJECT INFORMATION
========================================================= --}}

@php

    $existingSubjects = old(
        'subjects',
        is_array($enrolledStudent->subjects)
            ? $enrolledStudent->subjects
            : json_decode($enrolledStudent->subjects ?? '[]', true)
    );

    if (!is_array($existingSubjects)) {
        $existingSubjects = [];
    }

@endphp


<div class="form-section">

    <div class="form-section-header">

        <div class="section-icon">
            📚
        </div>

        <div>
            <h2>Subjects</h2>

            <p>
                Update the subjects the student will study
            </p>
        </div>

    </div>


    <div
        style="
            display:grid;
            grid-template-columns:repeat(3, 1fr);
            gap:14px;
            margin-top:10px;
        "
    >

        @foreach([
            'Physics',
            'Chemistry',
            'Mathematics',
            'English',
            'Biology',
            'Computer'
        ] as $subject)

            <label
                class="subject-option"
                style="
                    display:flex;
                    align-items:center;
                    gap:12px;
                    padding:16px;
                    border:1px solid #e2e8f0;
                    border-radius:12px;
                    cursor:pointer;
                    background:#ffffff;
                "
            >

                <input
                    type="checkbox"
                    name="subjects[]"
                    value="{{ $subject }}"
                    class="subject-checkbox"
                    {{ in_array($subject, $existingSubjects) ? 'checked' : '' }}
                >

                <span>
                    {{ $subject }}
                </span>

            </label>

        @endforeach

    </div>


    {{-- Subject Count --}}
    <div
        style="
            margin-top:20px;
            padding:15px 18px;
            border-radius:12px;
            background:#f8fafc;
            border:1px solid #e2e8f0;
            display:flex;
            justify-content:space-between;
            align-items:center;
        "
    >

        <span style="font-weight:600;">
            Selected Subjects
        </span>

        <strong
            id="subjects-count"
            style="font-size:16px;"
        >
            0 Subjects
        </strong>

    </div>


    @error('subjects')

        <small class="form-error">
            {{ $message }}
        </small>

    @enderror

</div>



{{-- =========================================================
     CONTACT INFORMATION
========================================================= --}}

<div class="form-section">

    <div class="form-section-header">

        <div class="section-icon">
            ☎
        </div>

        <div>
            <h2>Contact Information</h2>

            <p>
                Contact details of the student or guardian
            </p>
        </div>

    </div>


    <div class="form-grid">


        {{-- Phone --}}
        <div class="form-group">

            <label for="phone_number">
                Phone Number
                <span>*</span>
            </label>

            <input
                type="text"
                id="phone_number"
                name="phone_number"
                value="{{ old('phone_number', $enrolledStudent->phone_number) }}"
                placeholder="03XX-XXXXXXX"
                class="form-input"
                required
            >

            @error('phone_number')

                <small class="form-error">
                    {{ $message }}
                </small>

            @enderror

        </div>


        {{-- WhatsApp --}}
        <div class="form-group">

            <label for="whatsapp_number">
                WhatsApp Number
            </label>

            <input
                type="text"
                id="whatsapp_number"
                name="whatsapp_number"
                value="{{ old('whatsapp_number', $enrolledStudent->whatsapp_number) }}"
                placeholder="03XX-XXXXXXX"
                class="form-input"
            >

            @error('whatsapp_number')

                <small class="form-error">
                    {{ $message }}
                </small>

            @enderror

        </div>
        <div class="form-group">
    <label for="section">
        Section
        <span>*</span>
    </label>

    <select
        id="section"
        name="section"
        class="form-input"
        required
    >
        <option value="">Select Section</option>

        @foreach(['C-I', 'C-II', 'C-III', 'C-IV'] as $section)
            <option
                value="{{ $section }}"
                {{ old('section', $enrolledStudent->section) == $section ? 'selected' : '' }}
            >
                {{ $section }}
            </option>
        @endforeach
    </select>

    @error('section')
        <small class="form-error">{{ $message }}</small>
    @enderror
</div>

    </div>

</div>

{{-- =========================================================
     STUDENT STATUS
========================================================= --}}

<div class="form-section">

    <div class="form-section-header">

        <div class="section-icon">
            ●
        </div>

        <div>
            <h2>Student Status</h2>
            <p>
                Update the current status of the student
            </p>
        </div>

    </div>

    <div class="form-grid">

        <div class="form-group">

            <label for="status">
                Status
            </label>

            <select
                id="status"
                name="status"
                class="form-input"
                required
            >

                <option
                    value="Active"
                    {{ old('status', $enrolledStudent->status) === 'Active' ? 'selected' : '' }}
                >
                    Active
                </option>

                <option
                    value="Inactive"
                    {{ old('status', $enrolledStudent->status) === 'Inactive' ? 'selected' : '' }}
                >
                    Inactive
                </option>

            </select>

            @error('status')
                <small class="form-error">
                    {{ $message }}
                </small>
            @enderror

        </div>

        <div class="form-group mb-3">
    <label for="status">Status</label>
    <select name="status" id="status" class="form-control" required>
        <option value="Active" {{ old('status', $enrolledStudent->status) === 'Active' ? 'selected' : '' }}>Active</option>
        <option value="Inactive" {{ old('status', $enrolledStudent->status) === 'Inactive' ? 'selected' : '' }}>Inactive / Left</option>
    </select>
</div>

<div class="form-group mb-3" id="leaving_date_group">
    <label for="leaving_date">Date of Leaving (Required if Inactive)</label>
    <input type="date" name="leaving_date" id="leaving_date" 
           value="{{ old('leaving_date', $enrolledStudent->leaving_date) }}" 
           class="form-control">
    <small class="text-muted">If left blank while setting to Inactive, today's date will be used.</small>
</div>

    </div>

</div>



{{-- =========================================================
     FEE INFORMATION
========================================================= --}}

<div class="form-section">

    <div class="form-section-header">

        <div class="section-icon">
            ₨
        </div>

        <div>

            <h2>Fee Information</h2>

            <p>
                Fee is automatically calculated from the fee structure
            </p>

        </div>

    </div>


    <div class="form-grid">


        {{-- Admission Fee --}}
        <div class="form-group">

            <label for="admission_fee">
                Admission Fee
            </label>

            <div class="input-with-prefix">

                <span>
                    Rs.
                </span>

                <input
                    type="number"
                    id="admission_fee"
                    name="admission_fee"
                    value="{{ old('admission_fee', $enrolledStudent->admission_fee ?? 1000) }}"
                    class="form-input"
                    min="0"
                    step="0.01"
                >

            </div>

            <small class="form-hint">
                One-time admission fee.
            </small>

            @error('admission_fee')

                <small class="form-error">
                    {{ $message }}
                </small>

            @enderror

        </div>


        {{-- Base Fee --}}
        <div class="form-group">

            <label for="base_fee_display">
                Base Monthly Fee
            </label>

            <div class="input-with-prefix">

                <span>
                    Rs.
                </span>

                <input
                    type="text"
                    id="base_fee_display"
                    class="form-input"
                    value="0"
                    readonly
                >

            </div>

        </div>


        {{-- Discount --}}
        <div class="form-group">

            <label for="discount">
                Discount
            </label>

            <div class="input-with-prefix">

                <span>
                    Rs.
                </span>

                <input
                    type="number"
                    id="discount"
                    name="discount"
                    class="form-input"
                    value="{{ old('discount', $enrolledStudent->discount ?? 0) }}"
                    placeholder="0"
                    min="0"
                    step="0.01"
                >

            </div>

            @error('discount')

                <small class="form-error">
                    {{ $message }}
                </small>

            @enderror

        </div>


        {{-- Final Fee --}}
        <div class="form-group">

            <label for="fees_display">
                Final Monthly Fee
            </label>

            <div class="input-with-prefix">

                <span>
                    Rs.
                </span>

                <input
                    type="text"
                    id="fees_display"
                    class="form-input"
                    value="0"
                    readonly
                >

            </div>

        </div>

    </div>


    {{-- Fee Calculation Message --}}
    <div
        id="fee-message"
        style="
            margin-top:20px;
            padding:16px 18px;
            border-radius:12px;
            background:#f8fafc;
            border:1px solid #e2e8f0;
            color:#64748b;
            font-size:14px;
        "
    >
        Select class, board and subjects to calculate the fee.
    </div>

</div>



{{-- =========================================================
     CURRENT FEE STATUS
========================================================= --}}

<div class="form-section">

    <div class="form-section-header">

        <div class="section-icon">
            ✓
        </div>

        <div>

            <h2>Current Fee Status</h2>

            <p>
                Current payment status of this student
            </p>

        </div>

    </div>


    <div class="fee-status-info">

        <div class="fee-status-badge">
            {{ $enrolledStudent->fee_status ?? 'Fee Defaulter' }}
        </div>

        <p>
            Fee status is managed through the
            <strong>Fee Collection</strong>
            system.
        </p>

        <small>
            Changing subjects or discount will update the student's
            monthly fee, but will not automatically change the payment status.
        </small>

    </div>

</div>



{{-- =========================================================
     FORM ACTIONS
========================================================= --}}

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
        Update Student
    </button>

</div>


</form>

</div>



{{-- =========================================================
     FEE CALCULATION JAVASCRIPT
========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const classSelect =
        document.getElementById('class');

    const boardSelect =
        document.getElementById('board');

    const subjectCheckboxes =
        document.querySelectorAll('.subject-checkbox');

    const subjectsCount =
        document.getElementById('subjects-count');

    const discountInput =
        document.getElementById('discount');

    const baseFeeDisplay =
        document.getElementById('base_fee_display');

    const finalFeeDisplay =
        document.getElementById('fees_display');

    const feeMessage =
        document.getElementById('fee-message');


    /*
    |--------------------------------------------------------------------------
    | Fee Structures
    |--------------------------------------------------------------------------
    */

    const feeStructures =
        @json($feeStructures);


    /*
    |--------------------------------------------------------------------------
    | Calculate Fee
    |--------------------------------------------------------------------------
    */

    function calculateFee() {

        const selectedSubjects =
            document.querySelectorAll(
                '.subject-checkbox:checked'
            ).length;


        const selectedClass =
            classSelect.value;


        const selectedBoard =
            boardSelect.value;


        /*
        |--------------------------------------------------------------------------
        | Subject Count
        |--------------------------------------------------------------------------
        */

        subjectsCount.textContent =
            selectedSubjects +
            (
                selectedSubjects === 1
                    ? ' Subject'
                    : ' Subjects'
            );


        /*
        |--------------------------------------------------------------------------
        | Empty Selection
        |--------------------------------------------------------------------------
        */

        if (
            !selectedClass ||
            !selectedBoard ||
            selectedSubjects === 0
        ) {

            baseFeeDisplay.value = '0';

            finalFeeDisplay.value = '0';

            feeMessage.textContent =
                'Select class, board and subjects to calculate the fee.';

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Find Fee Structure
        |--------------------------------------------------------------------------
        */

        const structure =
            feeStructures.find(function (item) {

                return (

                    item.class === selectedClass &&

                    item.board === selectedBoard &&

                    Number(item.number_of_subjects) ===
                    selectedSubjects

                );

            });


        /*
        |--------------------------------------------------------------------------
        | Structure Not Found
        |--------------------------------------------------------------------------
        */

        if (!structure) {

            baseFeeDisplay.value = '0';

            finalFeeDisplay.value = '0';

            feeMessage.textContent =
                'No fee structure found for ' +
                selectedClass +
                ' - ' +
                selectedBoard +
                ' with ' +
                selectedSubjects +
                ' subjects.';

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Base Fee
        |--------------------------------------------------------------------------
        */

        const baseFee =
            Number(structure.monthly_fee);


        /*
        |--------------------------------------------------------------------------
        | Discount
        |--------------------------------------------------------------------------
        */

        let discount =
            Number(discountInput.value) || 0;


        if (discount > baseFee) {

            discount = baseFee;

            discountInput.value = baseFee;

        }


        /*
        |--------------------------------------------------------------------------
        | Final Fee
        |--------------------------------------------------------------------------
        */

        const finalFee =
            baseFee - discount;


        baseFeeDisplay.value =
            baseFee.toLocaleString('en-PK');


        finalFeeDisplay.value =
            finalFee.toLocaleString('en-PK');


        /*
        |--------------------------------------------------------------------------
        | Message
        |--------------------------------------------------------------------------
        */

        feeMessage.textContent =
            selectedClass +
            ' • ' +
            selectedBoard +
            ' • ' +
            selectedSubjects +
            (
                selectedSubjects === 1
                    ? ' Subject'
                    : ' Subjects'
            ) +
            ' → Base Fee Rs. ' +
            baseFee.toLocaleString('en-PK') +
            ' → Discount Rs. ' +
            discount.toLocaleString('en-PK') +
            ' → Final Fee Rs. ' +
            finalFee.toLocaleString('en-PK');

    }


    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */

    classSelect.addEventListener(
        'change',
        calculateFee
    );


    boardSelect.addEventListener(
        'change',
        calculateFee
    );


    discountInput.addEventListener(
        'input',
        calculateFee
    );


    subjectCheckboxes.forEach(function (checkbox) {

        checkbox.addEventListener(
            'change',
            calculateFee
        );

    });


    /*
    |--------------------------------------------------------------------------
    | Initial Calculation
    |--------------------------------------------------------------------------
    */

    calculateFee();

});

</script>

@endsection