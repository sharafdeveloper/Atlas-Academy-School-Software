@extends('layouts.app')

@section('title', 'Edit Fee Structure')

@section('content')

<div class="page-header">

    <div>
        <h1 class="page-title">
            Edit Fee Structure
        </h1>

        <p class="page-subtitle">
            Update the monthly tuition fee structure.
        </p>
    </div>

    <a
        href="{{ route('fee-structures.index') }}"
        class="secondary-btn"
    >
        ← Back to Fee Structure
    </a>

</div>


<div class="form-card">

    <div class="form-section">

        <div class="form-section-header">

            <div class="section-icon">
                ₨
            </div>

            <div>

                <h2>
                    Update Fee Structure
                </h2>

                <p>
                    Modify class, board, subject count or monthly fee.
                </p>

            </div>

        </div>


        <form
            action="{{ route('fee-structures.update', $feeStructure->id) }}"
            method="POST"
        >

            @csrf

            @method('PUT')


            <div class="form-grid">


                {{-- Class --}}

                <div class="form-group">

                    <label for="class">
                        Class
                        <span>*</span>
                    </label>

                    <select
                        name="class"
                        id="class"
                        class="form-input"
                        required
                    >

                        <option value="">
                            Select Class
                        </option>

                        @foreach(['IX', 'X', 'XI', 'XII'] as $class)

                            <option
                                value="{{ $class }}"
                                {{ old('class', $feeStructure->class) == $class ? 'selected' : '' }}
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
                        name="board"
                        id="board"
                        class="form-input"
                        required
                    >

                        <option value="">
                            Select Board
                        </option>

                        <option
                            value="Karachi Board"
                            {{ old('board', $feeStructure->board) == 'Karachi Board' ? 'selected' : '' }}
                        >
                            Karachi Board
                        </option>

                        <option
                            value="Federal Board"
                            {{ old('board', $feeStructure->board) == 'Federal Board' ? 'selected' : '' }}
                        >
                            Federal Board
                        </option>

                    </select>


                    @error('board')

                        <small class="form-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>



                {{-- Number of Subjects --}}

                <div class="form-group">

                    <label for="number_of_subjects">
                        Number of Subjects
                        <span>*</span>
                    </label>

                    <select
                        name="number_of_subjects"
                        id="number_of_subjects"
                        class="form-input"
                        required
                    >

                        <option value="">
                            Select Number of Subjects
                        </option>

                        @for($i = 1; $i <= 6; $i++)

                            <option
                                value="{{ $i }}"
                                {{ old('number_of_subjects', $feeStructure->number_of_subjects) == $i ? 'selected' : '' }}
                            >
                                {{ $i }}
                                {{ $i == 1 ? 'Subject' : 'Subjects' }}
                            </option>

                        @endfor

                    </select>


                    @error('number_of_subjects')

                        <small class="form-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>



                {{-- Monthly Fee --}}

                <div class="form-group">

                    <label for="monthly_fee">
                        Monthly Fee
                        <span>*</span>
                    </label>

                    <input
                        type="number"
                        name="monthly_fee"
                        id="monthly_fee"
                        class="form-input"
                        value="{{ old('monthly_fee', $feeStructure->monthly_fee) }}"
                        placeholder="Enter monthly fee"
                        min="0"
                        step="0.01"
                        required
                    >


                    @error('monthly_fee')

                        <small class="form-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>

            </div>


            {{-- Information --}}

            <div
                style="
                    margin-top:25px;
                    padding:18px 20px;
                    border-radius:12px;
                    background:#f8fafc;
                    border:1px solid #e2e8f0;
                "
            >

                <strong>
                    Current Fee Structure
                </strong>

                <p
                    style="
                        margin:7px 0 0;
                        color:#64748b;
                        font-size:14px;
                    "
                >

                    {{ $feeStructure->class }}

                    ·

                    {{ $feeStructure->board }}

                    ·

                    {{ $feeStructure->number_of_subjects }}

                    {{ $feeStructure->number_of_subjects == 1 ? 'Subject' : 'Subjects' }}

                    ·

                    Rs. {{ number_format($feeStructure->monthly_fee, 2) }}

                </p>

            </div>


            {{-- Actions --}}

            <div class="form-footer">

                <a
                    href="{{ route('fee-structures.index') }}"
                    class="cancel-btn"
                >
                    Cancel
                </a>


                <button
                    type="submit"
                    class="save-btn"
                >
                    Update Fee Structure
                </button>

            </div>

        </form>

    </div>

</div>

@endsection