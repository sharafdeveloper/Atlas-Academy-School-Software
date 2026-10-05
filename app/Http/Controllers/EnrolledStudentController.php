<?php

namespace App\Http\Controllers;

use App\Models\EnrolledStudent;
use App\Models\FeeStructure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EnrolledStudentController extends Controller
{
    /**
     * Display enrolled students.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Available Months
        |--------------------------------------------------------------------------
        */

        $availableMonths = [];

        $startDate = now()->startOfYear();
        $endDate = now()->endOfMonth();

        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {

            $availableMonths[] = [
                'value' => $currentDate->format('Y-m'),
                'label' => $currentDate->format('F Y'),
            ];

            $currentDate->addMonth();
        }


        /*
        |--------------------------------------------------------------------------
        | Selected Month
        |--------------------------------------------------------------------------
        */

        $selectedMonth = $request->input(
            'month',
            now()->format('Y-m')
        );


        /*
        |--------------------------------------------------------------------------
        | Validate Selected Month
        |--------------------------------------------------------------------------
        */

        try {

            $selectedDate = Carbon::createFromFormat(
                'Y-m',
                $selectedMonth
            )->startOfMonth();

            $selectedMonth = $selectedDate->format('Y-m');

        } catch (\Exception $e) {

            $selectedDate = now()->startOfMonth();

            $selectedMonth = $selectedDate->format('Y-m');
        }


        /*
        |--------------------------------------------------------------------------
        | Student Query
        |--------------------------------------------------------------------------
        */

       $query = EnrolledStudent::query();

// 1. Student must have been admitted on or before the end of the selected month
$query->whereDate('date_of_admission', '<=', $selectedDate->copy()->endOfMonth());

// 2. Student must NOT have left before this month started
$query->where(function ($q) use ($selectedDate) {
    $q->whereNull('leaving_date')
      ->orWhereDate('leaving_date', '>=', $selectedDate->copy()->startOfMonth());
});



        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'name',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'father_name',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'student_code',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'phone_number',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'whatsapp_number',
                    'like',
                    '%' . $search . '%'
                );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Class Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('class')) {

            $query->where(
                'class',
                $request->class
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Board Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('board')) {

            $query->where(
                'board',
                $request->board
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Load Students
        |--------------------------------------------------------------------------
        |
        | We get the students first and calculate their monthly fee
        | status based on the selected month.
        |
        */

        $students = $query
            ->with([
                'feePayments',
                'feePayments.allocations',
            ])
            ->latest('id')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Calculate Monthly Fee Status
        |--------------------------------------------------------------------------
        */

        foreach ($students as $student) {

            /*
            |--------------------------------------------------------------------------
            | IMPORTANT
            |--------------------------------------------------------------------------
            |
            | A student should not be considered due for a month that
            | occurred BEFORE their admission month.
            |
            */

            $admissionMonth = null;

            if (!empty($student->date_of_admission)) {

                try {

                    $admissionMonth = Carbon::parse(
                        $student->date_of_admission
                    )->format('Y-m');

                } catch (\Exception $e) {

                    $admissionMonth = null;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | If selected month is before admission month
            |--------------------------------------------------------------------------
            */

            if (
                $admissionMonth !== null &&
                $selectedMonth < $admissionMonth
            ) {

                $monthlyPaymentAmount = 0;

                $student->monthly_fee_status = 'Not Due';

                $student->monthly_paid_amount = 0;

                $student->monthly_remaining_amount = 0;

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Selected Month Name
            |--------------------------------------------------------------------------
            */

            $selectedMonthName = Carbon::createFromFormat(
                'Y-m',
                $selectedMonth
            )->format('F Y');


            /*
            |--------------------------------------------------------------------------
            | Calculate Amount Allocated To Selected Month
            |--------------------------------------------------------------------------
            */

            $monthlyPaymentAmount = 0;


            foreach ($student->feePayments as $payment) {

                foreach ($payment->allocations as $allocation) {

                    if (empty($allocation->fee_month)) {
                        continue;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Convert fee_month to Y-m
                    |--------------------------------------------------------------------------
                    |
                    | Your database may contain:
                    |
                    | September 2026
                    |
                    | OR
                    |
                    | 2026-09
                    |
                    */

                    $allocationMonth = null;


                    /*
                    |--------------------------------------------------------------------------
                    | First try Y-m format
                    |--------------------------------------------------------------------------
                    */

                    try {

                        $allocationMonth = Carbon::createFromFormat(
                            'Y-m',
                            $allocation->fee_month
                        )->format('Y-m');

                    } catch (\Exception $e) {

                        /*
                        |--------------------------------------------------------------------------
                        | Try normal Carbon parsing
                        |--------------------------------------------------------------------------
                        */

                        try {

                            $allocationMonth = Carbon::parse(
                                $allocation->fee_month
                            )->format('Y-m');

                        } catch (\Exception $e) {

                            $allocationMonth = null;
                        }
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Match selected month
                    |--------------------------------------------------------------------------
                    */

                    if ($allocationMonth === $selectedMonth) {

                        $monthlyPaymentAmount +=
                            (float) $allocation->amount_allocated;
                    }
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Expected Monthly Fee
            |--------------------------------------------------------------------------
            */

            $monthlyFee = (float) $student->fees;


            /*
            |--------------------------------------------------------------------------
            | Monthly Fee Status
            |--------------------------------------------------------------------------
            */

            if ($monthlyPaymentAmount >= $monthlyFee) {

                $student->monthly_fee_status = 'Paid';

            } else {

                $student->monthly_fee_status = 'Fee Defaulter';
            }


            /*
            |--------------------------------------------------------------------------
            | Amount Paid
            |--------------------------------------------------------------------------
            */

            $student->monthly_paid_amount =
                $monthlyPaymentAmount;


            /*
            |--------------------------------------------------------------------------
            | Remaining Amount
            |--------------------------------------------------------------------------
            */

            $student->monthly_remaining_amount =
                max(
                    0,
                    $monthlyFee - $monthlyPaymentAmount
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Fee Status Filter
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | This filter is applied BEFORE pagination.
        |
        */

        if ($request->filled('status')) {

            $students = $students
                ->filter(function ($student) use ($request) {

                    return $student->monthly_fee_status ===
                        $request->status;

                })
                ->values();
        }


        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalStudents =
            $students->count();


        $ixStudents =
            $students
                ->where('class', 'IX')
                ->count();


        $xStudents =
            $students
                ->where('class', 'X')
                ->count();


        $feeDefaulters =
            $students
                ->where(
                    'monthly_fee_status',
                    'Fee Defaulter'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Manual Pagination
        |--------------------------------------------------------------------------
        |
        | Because the monthly fee status is calculated in PHP,
        | we apply pagination AFTER the fee status filter.
        |
        */

        $perPage = 20;

        $currentPage =
            request()->input(
                'page',
                1
            );

        $students = new \Illuminate\Pagination\LengthAwarePaginator(

            $students
                ->forPage(
                    $currentPage,
                    $perPage
                )
                ->values(),

            $students->count(),

            $perPage,

            $currentPage,

            [
                'path' =>
                    request()->url(),

                'query' =>
                    request()->query(),
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'enrolled_students.index',
            compact(
                'students',
                'availableMonths',
                'selectedMonth',
                'totalStudents',
                'ixStudents',
                'xStudents',
                'feeDefaulters'
            )
        );
    }


    /**
     * Show create form.
     */
    public function create()
    {
        $feeStructures = FeeStructure::orderBy('class')
            ->orderBy('board')
            ->orderBy('number_of_subjects')
            ->get();

        return view(
            'enrolled_students.create',
            compact('feeStructures')
        );
    }
public function show(EnrolledStudent $enrolledStudent)
{
    return view('enrolled_students.show', compact('enrolledStudent'));
}


    /**
     * Store new student.
     */
    public function store(Request $request)
    {
        $request->validate([

            'name' =>
                'required|string|max:255',

            'father_name' =>
                'required|string|max:255',

            'class' =>
                'required|in:IX,X,XI,XII',
            'section' =>
    'required|in:C-I,C-II,C-III,C-IV',

            'board' =>
                'required|in:Federal Board,Karachi Board',

            'date_of_admission' =>
                'required|date',

            'subjects' =>
                'required|array|min:1',

            'subjects.*' =>
                'required|string|max:255',

            'discount' =>
                'nullable|numeric|min:0',

            'admission_fee' =>
                'nullable|numeric|min:0',

            'phone_number' =>
                'required|string|max:20',

            'whatsapp_number' =>
                'nullable|string|max:20',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Subjects
        |--------------------------------------------------------------------------
        */

        $subjects =
            $request->input('subjects', []);

        $subjectsCount =
            count($subjects);


        /*
        |--------------------------------------------------------------------------
        | Find Fee Structure
        |--------------------------------------------------------------------------
        */

        $feeStructure = FeeStructure::where(
            'class',
            $request->class
        )
        ->where(
            'board',
            $request->board
        )
        ->where(
            'number_of_subjects',
            $subjectsCount
        )
        ->first();


        if (!$feeStructure) {

            return back()
                ->withInput()
                ->withErrors([
                    'subjects' =>
                        'No fee structure exists for this class, board and number of selected subjects.'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Calculate Fee
        |--------------------------------------------------------------------------
        */

        $baseFee =
            (float) $feeStructure->monthly_fee;

        $discount =
            (float) (
                $request->input(
                    'discount',
                    0
                ) ?? 0
            );


        if ($discount > $baseFee) {

            return back()
                ->withInput()
                ->withErrors([
                    'discount' =>
                        'Discount cannot be greater than the monthly fee.'
                ]);
        }


        $finalFee =
            $baseFee - $discount;

/*
|--------------------------------------------------------------------------
| Generate Student Code
|--------------------------------------------------------------------------
|
| Format:
| A-09-C-I-0001
|
| A      = Constant
| 09     = Class IX
| C-I    = Section
| 0001   = Incrementing number
|
*/

// Convert class into required code
$classCode = match ($request->class) {

    'IX'  => '09',
    'X'   => '10',
    'XI'  => '11',
    'XII' => '12',

    default => '00',
};


// Get selected section
$section = $request->section;


/*
|--------------------------------------------------------------------------
| Create Prefix
|--------------------------------------------------------------------------
*/

$prefix =
    'A' .
    $classCode .
    '' .
    $section .
    '-';


/*
|--------------------------------------------------------------------------
| Find Existing Codes For Same Class + Section
|--------------------------------------------------------------------------
*/

$studentCodes =
    EnrolledStudent::where(
        'student_code',
        'like',
        $prefix . '%'
    )
    ->pluck('student_code');


$highestNumber = 0;


/*
|--------------------------------------------------------------------------
| Find Highest Number
|--------------------------------------------------------------------------
*/

foreach ($studentCodes as $code) {

    $numberPart =
        substr(
            $code,
            strlen($prefix)
        );

    $number =
        (int) $numberPart;


    if (
        $number >
        $highestNumber
    ) {

        $highestNumber =
            $number;
    }
}


/*
|--------------------------------------------------------------------------
| Generate Next Number
|--------------------------------------------------------------------------
*/

$nextNumber =
    $highestNumber + 1;


$studentCode =
    $prefix .
    str_pad(
        $nextNumber,
        2,
        '0',
        STR_PAD_LEFT
    );


/*
|--------------------------------------------------------------------------
| Make Sure Student Code Is Unique
|--------------------------------------------------------------------------
*/

while (
    EnrolledStudent::where(
        'student_code',
        $studentCode
    )->exists()
) {

    $nextNumber++;

    $studentCode =
        $prefix .
        str_pad(
            $nextNumber,
            2,
            '0',
            STR_PAD_LEFT
        );
}


        /*
        |--------------------------------------------------------------------------
        | Admission Fee
        |--------------------------------------------------------------------------
        */

        $admissionFee =
            (float) (
                $request->input(
                    'admission_fee',
                    0
                ) ?? 0
            );


        /*
        |--------------------------------------------------------------------------
        | Create Student
        |--------------------------------------------------------------------------
        */

        EnrolledStudent::create([

            'student_code' =>
                $studentCode,

            'name' =>
                $request->name,

            'father_name' =>
                $request->father_name,

            'class' =>
                $request->class,

            'section' =>
    $request->section,

            'board' =>
                $request->board,

            'date_of_admission' =>
                $request->date_of_admission,

            'subjects' =>
                $subjects,

            'subjects_count' =>
                $subjectsCount,

            'base_fee' =>
                $baseFee,

            'discount' =>
                $discount,

            'fees' =>
                $finalFee,

            'admission_fee' =>
                $admissionFee,

            'fee_status' =>
                'Fee Defaulter',

            'status' =>
                'Active',

            'phone_number' =>
                $request->phone_number,

            'whatsapp_number' =>
                $request->whatsapp_number,
        ]);


        return redirect()
            ->route(
                'enrolled-students.index'
            )
            ->with(
                'success',
                'Student added successfully. Student Code: '
                . $studentCode
            );
    }


    /**
     * Show edit form.
     */
    public function edit(
        EnrolledStudent $enrolledStudent
    ) {

        $feeStructures =
            FeeStructure::orderBy('class')
                ->orderBy('board')
                ->orderBy('number_of_subjects')
                ->get();


        return view(
            'enrolled_students.edit',
            compact(
                'enrolledStudent',
                'feeStructures'
            )
        );
    }


    /**
     * Update student.
     */
    /**
     * Update student.
     */
    public function update(
        Request $request,
        EnrolledStudent $enrolledStudent
    ) {
        $request->validate([
            'name' =>
                'required|string|max:255',

            'father_name' =>
                'required|string|max:255',

            'class' =>
                'required|in:IX,X,XI,XII',

            'section' =>
                'required|in:C-I,C-II,C-III,C-IV',

            'board' =>
                'required|in:Federal Board,Karachi Board',

            'date_of_admission' =>
                'required|date',

            'subjects' =>
                'required|array|min:1',

            'subjects.*' =>
                'required|string|max:255',

            'discount' =>
                'nullable|numeric|min:0',

            'admission_fee' =>
                'nullable|numeric|min:0',

            'phone_number' =>
                'required|string|max:20',

            'whatsapp_number' =>
                'nullable|string|max:20',

            'status' =>
                'required|in:Active,Inactive',

            'leaving_date' =>
                'nullable|date',
        ]);

        $subjects = $request->input('subjects', []);
        $subjectsCount = count($subjects);

        /*
        |--------------------------------------------------------------------------
        | Fee Structure
        |--------------------------------------------------------------------------
        */
        $feeStructure = FeeStructure::where('class', $request->class)
            ->where('board', $request->board)
            ->where('number_of_subjects', $subjectsCount)
            ->first();

        if (!$feeStructure) {
            return back()
                ->withInput()
                ->withErrors([
                    'subjects' => 'No fee structure exists for this class, board and number of selected subjects.'
                ]);
        }

        $baseFee = (float) $feeStructure->monthly_fee;

        $discount = (float) ($request->input('discount', 0) ?? 0);

        if ($discount > $baseFee) {
            return back()
                ->withInput()
                ->withErrors([
                    'discount' => 'Discount cannot be greater than the monthly fee.'
                ]);
        }

        $finalFee = $baseFee - $discount;

        $admissionFee = (float) ($request->input('admission_fee', 0) ?? 0);

        /*
        |--------------------------------------------------------------------------
        | Determine Leaving Date
        |--------------------------------------------------------------------------
        */
        $leavingDate = $request->leaving_date;

        if ($request->status === 'Inactive') {
            // Default to today if left blank on deactivation
            $leavingDate = $leavingDate ?: ($enrolledStudent->leaving_date ?: now()->toDateString());
        } else {
            // If reactivated to 'Active', clear the leaving date
            $leavingDate = null;
        }

        /*
        |--------------------------------------------------------------------------
        | Update Record
        |--------------------------------------------------------------------------
        */
        $enrolledStudent->update([
            'name' => $request->name,
            'father_name' => $request->father_name,
            'class' => $request->class,
            'section' => $request->section,
            'board' => $request->board,
            'date_of_admission' => $request->date_of_admission,
            'subjects' => $subjects,
            'subjects_count' => $subjectsCount,
            'base_fee' => $baseFee,
            'discount' => $discount,
            'fees' => $finalFee,
            'admission_fee' => $admissionFee,
            'phone_number' => $request->phone_number,
            'whatsapp_number' => $request->whatsapp_number,
            'status' => $request->status,
            'leaving_date' => $leavingDate,
        ]);

        return redirect()
            ->route('enrolled-students.index')
            ->with(
                'success',
                'Student updated successfully.'
            );
    }
    
    public function destroy(
        EnrolledStudent $enrolledStudent
    ) {

        $enrolledStudent->delete();


        return redirect()
            ->route(
                'enrolled-students.index'
            )
            ->with(
                'success',
                'Student deleted successfully.'
            );
    }
}