
@extends('layouts.app')

@section('title', 'Add Enrolled Student')

@section('content')

<div class="page-header">

    <div>
        <h1 class="page-title">Add Enrolled Student</h1>

        <p class="page-subtitle">
            Add a new student to the academy
        </p>
    </div>

    <a href="{{ route('enrolled-students.index') }}" class="secondary-btn">
        ← Back to Students
    </a>

</div>


<div class="form-card">

<form
    action="{{ route('enrolled-students.store') }}"
    method="POST"
>

@csrf


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
                Enter the basic information of the student
            </p>
        </div>

    </div>


    <div class="form-grid">


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
                value="{{ old('name') }}"
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
                value="{{ old('father_name') }}"
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


        


        <!-- {{-- Student Code --}}

        <div class="form-group">

            <label for="student_code">
                Student Code
                <span>*</span>
            </label>

            <input
                type="text"
                id="student_code"
                name="student_code"
                value="{{ old('student_code') }}"
                placeholder="Enter student_code"
                class="form-input"
                required
            >

            @error('student_code')
                <small class="form-error">
                    {{ $message }}
                </small>
            @enderror

        </div> -->



 {{-- Student Code --}}

        <div class="form-group">

            <label for="student_code">
                Student Code
            </label>

            <input
                type="text"
                id="student_code"
                value="Will be generated automatically"
                class="form-input"
                readonly
            >

            <small class="form-hint">
                Student code will be generated automatically.
            </small>

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
                        {{ old('class') == $class ? 'selected' : '' }}
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
                    {{ old('board') == 'Federal Board' ? 'selected' : '' }}
                >
                    Federal Board
                </option>

                <option
                    value="Karachi Board"
                    {{ old('board') == 'Karachi Board' ? 'selected' : '' }}
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
                value="{{ old('date_of_admission', now()->format('Y-m-d')) }}"
                class="form-input"
                required
            >

            @error('date_of_admission')

                <small class="form-error">
                    {{ $message }}
                </small>

            @enderror

        </div>

        <div class="form-group">
    <label for="section">Section</label>

    <select name="section" id="section" class="form-control">
        <option value="">Select Section</option>
        <option value="C-I">C-I</option>
        <option value="C-II">C-II</option>
        <option value="C-III">C-III</option>
        <option value="C-IV">C-IV</option>
    </select>
</div>


    </div>

</div>



{{-- =========================================================
     SUBJECT INFORMATION
========================================================= --}}

<div class="form-section">

    <div class="form-section-header">

        <div class="section-icon">
            📚
        </div>

        <div>

            <h2>Subjects</h2>

            <p>
                Select the subjects the student will study
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


        {{-- Physics --}}

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
                value="Physics"
                class="subject-checkbox"
                {{ in_array('Physics', old('subjects', [])) ? 'checked' : '' }}
            >

            <span>
                Physics
            </span>

        </label>


        {{-- Chemistry --}}

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
                value="Chemistry"
                class="subject-checkbox"
                {{ in_array('Chemistry', old('subjects', [])) ? 'checked' : '' }}
            >

            <span>
                Chemistry
            </span>

        </label>


        {{-- Mathematics --}}

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
                value="Mathematics"
                class="subject-checkbox"
                {{ in_array('Mathematics', old('subjects', [])) ? 'checked' : '' }}
            >

            <span>
                Mathematics
            </span>

        </label>


        {{-- English --}}

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
                value="English"
                class="subject-checkbox"
                {{ in_array('English', old('subjects', [])) ? 'checked' : '' }}
            >

            <span>
                English
            </span>

        </label>


        {{-- Biology --}}

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
                value="Biology"
                class="subject-checkbox"
                {{ in_array('Biology', old('subjects', [])) ? 'checked' : '' }}
            >

            <span>
                Biology
            </span>

        </label>


        {{-- Computer --}}

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
                value="Computer"
                class="subject-checkbox"
                {{ in_array('Computer', old('subjects', [])) ? 'checked' : '' }}
            >

            <span>
                Computer
            </span>

        </label>

    </div>


    {{-- Selected Subjects Count --}}

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
                value="{{ old('phone_number') }}"
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
                value="{{ old('whatsapp_number') }}"
                placeholder="03XX-XXXXXXX"
                class="form-input"
            >

            @error('whatsapp_number')

                <small class="form-error">
                    {{ $message }}
                </small>

            @enderror

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
                Admission fee and monthly fee information
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
    value="{{ old('admission_fee', 0) }}"
    class="form-input"
    placeholder="Enter admission fee"
    min="0"
    step="0.01"
>

            </div>

            <small class="form-hint">
                One-time admission fee
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
                    value="{{ old('discount', 0) }}"
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
     FEE STATUS
========================================================= --}}

<div class="form-section">

    <div class="form-section-header">

        <div class="section-icon">
            ✓
        </div>

        <div>

            <h2>Fee Status</h2>

            <p>
                New students will initially be marked as defaulters
            </p>

        </div>

    </div>


    <div class="fee-status-info">

        <div class="fee-status-badge">
            Fee Defaulter
        </div>

        <p>

            New students are automatically marked as

            <strong>
                Fee Defaulter
            </strong>.

        </p>

        <small>

            The status will change to

            <strong>
                Paid
            </strong>

            after payment is collected.

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
        id="submit-btn"
    >
        Add Student
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

    const feeStructures = {{ Js::from(
        \App\Models\FeeStructure::select(
            'class',
            'board',
            'number_of_subjects',
            'monthly_fee'
        )->get()
    ) }};


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
        | Update Subject Count
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
        | No Class / Board / Subjects
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
        | Find Matching Fee Structure
        |--------------------------------------------------------------------------
        */

        const structure =
            feeStructures.find(function (item) {

                return (

                    item.class === selectedClass &&

                    item.board === selectedBoard &&

                    Number(item.number_of_subjects) === selectedSubjects

                );

            });


        /*
        |--------------------------------------------------------------------------
        | Fee Structure Not Found
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


        /*
        |--------------------------------------------------------------------------
        | Prevent Discount Greater Than Base Fee
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | Display Fees
        |--------------------------------------------------------------------------
        */

        baseFeeDisplay.value =
            baseFee.toLocaleString('en-PK');


        finalFeeDisplay.value =
            finalFee.toLocaleString('en-PK');


        /*
        |--------------------------------------------------------------------------
        | Information Message
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
    | Event Listeners
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

