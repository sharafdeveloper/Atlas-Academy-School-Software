@extends('layouts.app')

@section('title', 'Edit Teacher')

@section('content')

<div class="page-header">

```
<div>
    <h1 class="page-title">Edit Teacher</h1>

    <p class="page-subtitle">
        Update teacher information and class charges
    </p>
</div>

<a
    href="{{ route('teachers.index') }}"
    class="secondary-btn"
>
    ← Back to Teachers
</a>
```

</div>

<div class="form-card">

```
<form
    action="{{ route('teachers.update', $teacher->id) }}"
    method="POST"
>

    @csrf
    @method('PUT')


    {{-- =========================
         TEACHER INFORMATION
    ========================== --}}

    <div class="form-section">

        <div class="form-section-header">

            <div class="section-icon">
                👨‍🏫
            </div>

            <div>

                <h2>Teacher Information</h2>

                <p>
                    Update the basic information of the teacher
                </p>

            </div>

        </div>


        <div class="form-grid">


            {{-- Teacher Name --}}

            <div class="form-group">

                <label for="name">
                    Teacher Name
                    <span>*</span>
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $teacher->name) }}"
                    placeholder="Enter teacher name"
                    class="form-input"
                    required
                >

                @error('name')

                    <small class="form-error">
                        {{ $message }}
                    </small>

                @enderror

            </div>


            {{-- Status --}}

            <div class="form-group">

                <label for="status">
                    Status
                    <span>*</span>
                </label>

                <select
                    id="status"
                    name="status"
                    class="form-input"
                    required
                >

                    <option
                        value="Active"
                        {{ old('status', $teacher->status) === 'Active'
                            ? 'selected'
                            : '' }}
                    >
                        Active
                    </option>

                    <option
                        value="Inactive"
                        {{ old('status', $teacher->status) === 'Inactive'
                            ? 'selected'
                            : '' }}
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


            {{-- Joining Date --}}

            <div class="form-group">

                <label for="joining_date">
                    Joining Date
                </label>

                <input
                    type="date"
                    id="joining_date"
                    name="joining_date"
                    value="{{ old(
                        'joining_date',
                        $teacher->joining_date
                            ? $teacher->joining_date->format('Y-m-d')
                            : ''
                    ) }}"
                    class="form-input"
                >

                @error('joining_date')

                    <small class="form-error">
                        {{ $message }}
                    </small>

                @enderror

            </div>

        </div>

    </div>



    {{-- =========================
         CONTACT INFORMATION
    ========================== --}}

    <div class="form-section">

        <div class="form-section-header">

            <div class="section-icon">
                ☎
            </div>

            <div>

                <h2>Contact Information</h2>

                <p>
                    Contact details of the teacher
                </p>

            </div>

        </div>


        <div class="form-grid">


            {{-- Phone --}}

            <div class="form-group">

                <label for="phone_number">
                    Phone Number
                </label>

                <input
                    type="text"
                    id="phone_number"
                    name="phone_number"
                    value="{{ old(
                        'phone_number',
                        $teacher->phone_number
                    ) }}"
                    placeholder="03XX-XXXXXXX"
                    class="form-input"
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
                    value="{{ old(
                        'whatsapp_number',
                        $teacher->whatsapp_number
                    ) }}"
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



    {{-- =========================
         CLASS & SALARY INFORMATION
    ========================== --}}

    <div class="form-section">

        <div class="form-section-header">

            <div class="section-icon">
                ₨
            </div>

            <div>

                <h2>Class & Salary Information</h2>

                <p>
                    Set weekly classes and per-class payment
                </p>

            </div>

        </div>


        <div class="form-grid">


            {{-- Weekly Classes --}}

            <div class="form-group">

                <label for="weekly_classes">

                    Total Classes Per Week

                    <span>*</span>

                </label>

                <input
                    type="number"
                    id="weekly_classes"
                    name="weekly_classes"
                    value="{{ old(
                        'weekly_classes',
                        $teacher->weekly_classes
                    ) }}"
                    placeholder="20"
                    min="0"
                    class="form-input"
                    required
                >

                @error('weekly_classes')

                    <small class="form-error">
                        {{ $message }}
                    </small>

                @enderror

            </div>


            {{-- Per Class Charge --}}

            <div class="form-group">

                <label for="per_class_charge">

                    Per Class Charge

                    <span>*</span>

                </label>

                <div class="input-with-prefix">

                    <span>
                        Rs.
                    </span>

                    <input
                        type="number"
                        id="per_class_charge"
                        name="per_class_charge"
                        value="{{ old(
                            'per_class_charge',
                            $teacher->per_class_charge
                        ) }}"
                        placeholder="500"
                        min="0"
                        step="0.01"
                        class="form-input"
                        required
                    >

                </div>

                @error('per_class_charge')

                    <small class="form-error">
                        {{ $message }}
                    </small>

                @enderror

            </div>

        </div>



        {{-- Salary Preview --}}

        <div
            style="
                margin-top:25px;
                display:grid;
                grid-template-columns:repeat(3, 1fr);
                gap:15px;
            "
        >

            <div
                style="
                    padding:18px;
                    border:1px solid #e2e8f0;
                    border-radius:14px;
                    background:#f8fafc;
                "
            >

                <div
                    style="
                        font-size:13px;
                        color:#64748b;
                        margin-bottom:7px;
                    "
                >
                    Weekly Salary
                </div>

                <strong
                    id="weekly-salary"
                    style="font-size:20px;"
                >
                    Rs. 0
                </strong>

            </div>


            <div
                style="
                    padding:18px;
                    border:1px solid #e2e8f0;
                    border-radius:14px;
                    background:#f8fafc;
                "
            >

                <div
                    style="
                        font-size:13px;
                        color:#64748b;
                        margin-bottom:7px;
                    "
                >
                    Estimated Monthly Salary
                </div>

                <strong
                    id="monthly-salary"
                    style="font-size:20px;"
                >
                    Rs. 0
                </strong>

            </div>


            <div
                style="
                    padding:18px;
                    border:1px solid #e2e8f0;
                    border-radius:14px;
                    background:#f8fafc;
                "
            >

                <div
                    style="
                        font-size:13px;
                        color:#64748b;
                        margin-bottom:7px;
                    "
                >
                    Yearly Estimate
                </div>

                <strong
                    id="yearly-salary"
                    style="font-size:20px;"
                >
                    Rs. 0
                </strong>

            </div>

        </div>


        <div
            style="
                margin-top:18px;
                padding:14px 16px;
                border-radius:12px;
                background:#f8fafc;
                border:1px solid #e2e8f0;
                color:#64748b;
                font-size:13px;
            "
        >

            Monthly estimate is calculated using
            <strong>4 weeks</strong>.

        </div>

    </div>



    {{-- =========================
         FORM ACTIONS
    ========================== --}}

    <div class="form-footer">

        <a
            href="{{ route('teachers.index') }}"
            class="cancel-btn"
        >
            Cancel
        </a>

        <button
            type="submit"
            class="save-btn"
        >
            Update Teacher
        </button>

    </div>

</form>
```

</div>

{{-- =========================
SALARY CALCULATION
========================== --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const weeklyClasses =
        document.getElementById('weekly_classes');

    const perClassCharge =
        document.getElementById('per_class_charge');

    const weeklySalary =
        document.getElementById('weekly-salary');

    const monthlySalary =
        document.getElementById('monthly-salary');

    const yearlySalary =
        document.getElementById('yearly-salary');


    function calculateSalary() {

        const classes =
            Number(weeklyClasses.value) || 0;

        const charge =
            Number(perClassCharge.value) || 0;


        const weekly =
            classes * charge;

        const monthly =
            weekly * 4;

        const yearly =
            monthly * 12;


        weeklySalary.textContent =
            'Rs. ' +
            weekly.toLocaleString('en-PK');


        monthlySalary.textContent =
            'Rs. ' +
            monthly.toLocaleString('en-PK');


        yearlySalary.textContent =
            'Rs. ' +
            yearly.toLocaleString('en-PK');

    }


    weeklyClasses.addEventListener(
        'input',
        calculateSalary
    );


    perClassCharge.addEventListener(
        'input',
        calculateSalary
    );


    calculateSalary();

});

</script>

@endsection
