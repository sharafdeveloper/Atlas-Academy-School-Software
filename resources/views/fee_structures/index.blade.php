@extends('layouts.app')

@section('title', 'Fee Structure')

@section('content')

<div class="page-header">

    <div>
        <h1 class="page-title">
            Fee Structure
        </h1>

        <p class="page-subtitle">
            Manage monthly tuition fees based on class, board and number of subjects.
        </p>
    </div>

    <a
        href="{{ route('fee-structures.create') }}"
        class="primary-btn"
    >
        + Add Fee Structure
    </a>

</div>


{{-- Success Message --}}
@if(session('success'))

    <div class="alert-success">
        {{ session('success') }}
    </div>

@endif


<div class="form-card">

    {{-- Header --}}

    <div class="form-section-header">

        <div class="section-icon">
            ₨
        </div>

        <div>
            <h2>Monthly Fee Structure</h2>

            <p>
                Set tuition fees according to class, board and subject count.
            </p>
        </div>

    </div>


    {{-- Table --}}

    <div style="overflow-x:auto; margin-top:25px;">

        <table class="data-table">

            <thead>

                <tr>

                    <th>
                        Class
                    </th>

                    <th>
                        Board
                    </th>

                    <th>
                        Number of Subjects
                    </th>

                    <th>
                        Monthly Fee
                    </th>

                    <th>
                        Status
                    </th>

                    <th>
                        Actions
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($feeStructures as $feeStructure)

                    <tr>

                        <td>
                            <strong>
                                {{ $feeStructure->class }}
                            </strong>
                        </td>


                        <td>
                            {{ $feeStructure->board }}
                        </td>


                        <td>

                            <span class="status-badge">

                                {{ $feeStructure->number_of_subjects }}

                                {{ $feeStructure->number_of_subjects == 1 ? 'Subject' : 'Subjects' }}

                            </span>

                        </td>


                        <td>

                            <strong>
                                Rs.
                                {{ number_format($feeStructure->monthly_fee, 2) }}
                            </strong>

                        </td>


                        <td>

                            @if($feeStructure->status)

                                <span class="status-badge status-paid">
                                    Active
                                </span>

                            @else

                                <span class="status-badge status-danger">
                                    Inactive
                                </span>

                            @endif

                        </td>


                        <td>

                            <div class="table-actions">

                                <a
                                    href="{{ route('fee-structures.edit', $feeStructure->id) }}"
                                    class="action-btn edit-btn"
                                >
                                    Edit
                                </a>


                                <form
                                    action="{{ route('fee-structures.destroy', $feeStructure->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this fee structure?');"
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

                        <td
                            colspan="6"
                            style="text-align:center; padding:50px;"
                        >

                            <div style="font-size:40px; margin-bottom:10px;">
                                ₨
                            </div>

                            <h3>
                                No Fee Structure Found
                            </h3>

                            <p style="margin-top:5px; color:#64748b;">
                                Start by adding your first fee structure.
                            </p>

                            <a
                                href="{{ route('fee-structures.create') }}"
                                class="primary-btn"
                                style="display:inline-block; margin-top:18px;"
                            >
                                + Add Fee Structure
                            </a>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection