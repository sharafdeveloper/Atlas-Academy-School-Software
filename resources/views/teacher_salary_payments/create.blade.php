@extends('layouts.app')

@section('title', 'Pay Salary')

@section('content')

<div class="page-header">


<div>
    <h1 class="page-title">Pay Salary</h1>

    <p class="page-subtitle">
        Process salary payment for {{ $teacher->name }}
    </p>
</div>

<a
    href="{{ route('teachers.show', $teacher->id) }}"
    class="secondary-btn"
>
    ← Back
</a>
```

</div>

@if(session('error'))

```
<div
    style="
        margin-bottom:20px;
        padding:15px 18px;
        border-radius:12px;
        background:#fef2f2;
        border:1px solid #fecaca;
        color:#b91c1c;
    "
>
    {{ session('error') }}
</div>
```

@endif

@if($alreadyPaid)

```
{{-- Already Paid --}}

<div
    class="form-card"
    style="
        max-width:750px;
        margin:0 auto;
        text-align:center;
    "
>

    <div
        style="
            width:70px;
            height:70px;
            margin:0 auto 20px;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            background:#ecfdf5;
            color:#059669;
            font-size:32px;
        "
    >
        ✓
    </div>

    <h2
        style="
            margin:0 0 8px;
            font-size:24px;
            color:#111827;
        "
    >
        Salary Already Paid
    </h2>

    <p
        style="
            margin:0;
            color:#64748b;
        "
    >
        {{ $teacher->name }}'s salary for
        <strong>{{ $currentMonth }}</strong>
        has already been paid.
    </p>

    <div
        style="
            margin:25px 0;
            padding:25px;
            border-radius:16px;
            background:#f8fafc;
            border:1px solid #e2e8f0;
        "
    >

        <div
            style="
                font-size:13px;
                color:#64748b;
                margin-bottom:8px;
            "
        >
            Paid Salary
        </div>

        <div
            style="
                font-size:32px;
                font-weight:700;
                color:#059669;
            "
        >
            Rs. {{ number_format($monthlySalary, 2) }}
        </div>

        <div
            style="
                margin-top:6px;
                font-size:13px;
                color:#94a3b8;
            "
        >
            {{ $currentMonth }}
        </div>

    </div>

    <a
        href="{{ route('teachers.show', $teacher->id) }}"
        class="save-btn"
        style="
            display:inline-block;
            text-decoration:none;
        "
    >
        View Teacher
    </a>

</div>
```

@else

```
{{-- Payment Form --}}

<div
    class="form-card"
    style="max-width:850px; margin:0 auto;"
>

    {{-- Teacher Header --}}

    <div
        style="
            display:flex;
            align-items:center;
            gap:16px;
            padding-bottom:22px;
            border-bottom:1px solid #e5e7eb;
        "
    >

        <div
            style="
                width:58px;
                height:58px;
                border-radius:16px;
                display:flex;
                align-items:center;
                justify-content:center;
                background:#eff6ff;
                color:#2563eb;
                font-size:24px;
                font-weight:700;
            "
        >
            {{ strtoupper(substr($teacher->name, 0, 1)) }}
        </div>

        <div>

            <h2
                style="
                    margin:0 0 5px;
                    font-size:21px;
                    color:#111827;
                "
            >
                {{ $teacher->name }}
            </h2>

            <p
                style="
                    margin:0;
                    color:#64748b;
                    font-size:13px;
                "
            >
                Salary payment for {{ $currentMonth }}
            </p>

        </div>

    </div>


    {{-- Salary Information --}}

    <div style="margin-top:25px;">

        <h3
            style="
                margin:0 0 18px;
                font-size:17px;
                color:#111827;
            "
        >
            Salary Details
        </h3>


        <div
            style="
                display:grid;
                grid-template-columns:repeat(3, 1fr);
                gap:16px;
            "
        >

            {{-- Weekly Classes --}}

            <div
                style="
                    padding:18px;
                    border-radius:14px;
                    background:#f8fafc;
                    border:1px solid #e2e8f0;
                "
            >

                <span
                    style="
                        display:block;
                        font-size:12px;
                        color:#64748b;
                        margin-bottom:7px;
                    "
                >
                    Classes Per Week
                </span>

                <strong
                    style="
                        font-size:21px;
                        color:#111827;
                    "
                >
                    {{ number_format($teacher->weekly_classes) }}
                </strong>

            </div>


            {{-- Per Class --}}

            <div
                style="
                    padding:18px;
                    border-radius:14px;
                    background:#f8fafc;
                    border:1px solid #e2e8f0;
                "
            >

                <span
                    style="
                        display:block;
                        font-size:12px;
                        color:#64748b;
                        margin-bottom:7px;
                    "
                >
                    Per Class Charge
                </span>

                <strong
                    style="
                        font-size:21px;
                        color:#111827;
                    "
                >
                    Rs. {{ number_format($teacher->per_class_charge, 2) }}
                </strong>

            </div>


            {{-- Month --}}

            <div
                style="
                    padding:18px;
                    border-radius:14px;
                    background:#f8fafc;
                    border:1px solid #e2e8f0;
                "
            >

                <span
                    style="
                        display:block;
                        font-size:12px;
                        color:#64748b;
                        margin-bottom:7px;
                    "
                >
                    Salary Month
                </span>

                <strong
                    style="
                        font-size:18px;
                        color:#111827;
                    "
                >
                    {{ $currentMonth }}
                </strong>

            </div>

        </div>

    </div>


    {{-- Amount --}}

    <div
        style="
            margin-top:25px;
            padding:25px;
            border-radius:16px;
            background:#f8fbff;
            border:1px solid #dbeafe;
            text-align:center;
        "
    >

        <div
            style="
                font-size:13px;
                color:#64748b;
                margin-bottom:8px;
            "
        >
            Salary Amount To Be Paid
        </div>

        <div
            style="
                font-size:36px;
                font-weight:700;
                color:#2563eb;
            "
        >
            Rs. {{ number_format($monthlySalary, 2) }}
        </div>

        <div
            style="
                margin-top:8px;
                font-size:12px;
                color:#94a3b8;
            "
        >
            Calculated using 4 weeks per month
        </div>

    </div>


    {{-- Payment Form --}}

    <form
        action="{{ route('teacher-salary-payments.store', $teacher->id) }}"
        method="POST"
        style="margin-top:25px;"
    >

        @csrf


        <div class="form-group">

            <label for="notes">
                Payment Notes
            </label>

            <textarea
                id="notes"
                name="notes"
                class="form-input"
                rows="4"
                placeholder="Optional payment notes..."
            >{{ old('notes') }}</textarea>

            @error('notes')

                <small class="form-error">
                    {{ $message }}
                </small>

            @enderror

        </div>


        {{-- Actions --}}

        <div
            class="form-footer"
            style="margin-top:25px;"
        >

            <a
                href="{{ route('teachers.show', $teacher->id) }}"
                class="cancel-btn"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="save-btn"
            >
                ✓ Pay Rs. {{ number_format($monthlySalary, 2) }}
            </button>

        </div>

    </form>

</div>


@endif

@endsection
