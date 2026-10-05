@extends('layouts.app')

@section('title', 'Add Inquiry Student')

@section('content')

<div class="page-header">

    <div>
        <h1 class="page-title">Add Inquiry Student</h1>

        <p class="page-subtitle">
            Add a new student inquiry to the academy
        </p>
    </div>

    <a href="{{ route('inquiry-students.index') }}" class="secondary-btn">
        ← Back to Inquiries
    </a>

</div>


<div class="form-card">

    <form
        action="{{ route('inquiry-students.store') }}"
        method="POST"
    >

        @csrf


        {{-- =========================
             STUDENT INFORMATION
        ========================== --}}

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

                {{-- Name --}}

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

                        <option value="IX"
                            {{ old('class') == 'IX' ? 'selected' : '' }}>
                            IX
                        </option>

                        <option value="X"
                            {{ old('class') == 'X' ? 'selected' : '' }}>
                            X
                        </option>

                        <option value="XI"
                            {{ old('class') == 'XI' ? 'selected' : '' }}>
                            XI
                        </option>

                        <option value="XII"
                            {{ old('class') == 'XII' ? 'selected' : '' }}>
                            XII
                        </option>

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

                        <option value="Federal Board"
                            {{ old('board') == 'Federal Board' ? 'selected' : '' }}>
                            Federal Board
                        </option>

                        <option value="Karachi Board"
                            {{ old('board') == 'Karachi Board' ? 'selected' : '' }}>
                            Karachi Board
                        </option>

                    </select>

                    @error('board')
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


        {{-- =========================
             INQUIRY INFORMATION
        ========================== --}}

        <div class="form-section">

            <div class="form-section-header">

                <div class="section-icon">
                    📝
                </div>

                <div>
                    <h2>Inquiry Information</h2>

                    <p>
                        Record the student's inquiry details
                    </p>
                </div>

            </div>


            <div class="form-grid">

                {{-- Inquiry Status --}}

                <div class="form-group">

                    <label for="status">
                        Inquiry Status
                        <span>*</span>
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="form-input"
                        required
                    >

                        <option value="">
                            Select Status
                        </option>

                        <option value="New"
                            {{ old('status') == 'New' ? 'selected' : '' }}>
                            New
                        </option>

                        <option value="Follow Up"
                            {{ old('status') == 'Follow Up' ? 'selected' : '' }}>
                            Follow Up
                        </option>

                        <option value="Joined"
                            {{ old('status') == 'Joined' ? 'selected' : '' }}>
                            Joined
                        </option>

                        <option value="Not Interested"
                            {{ old('status') == 'Not Interested' ? 'selected' : '' }}>
                            Not Interested
                        </option>

                    </select>

                    @error('status')
                        <small class="form-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- Notes --}}

                <div class="form-group">

                    <label for="notes">
                        Notes
                    </label>

                    <textarea
                        id="notes"
                        name="notes"
                        class="form-input form-textarea"
                        placeholder="Enter any additional information..."
                    >{{ old('notes') }}</textarea>

                    @error('notes')
                        <small class="form-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

            </div>

        </div>


        {{-- =========================
             FORM ACTIONS
        ========================== --}}

        <div class="form-footer">

            <a
                href="{{ route('inquiry-students.index') }}"
                class="cancel-btn"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="save-btn"
            >
                Add Inquiry
            </button>

        </div>

    </form>

</div>

@endsection