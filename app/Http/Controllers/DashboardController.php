<?php

namespace App\Http\Controllers;

use App\Models\FeePayment;
use App\Models\TeacherSalaryPayment;
use App\Models\EnrolledStudent;
use App\Models\Teacher;
use App\Models\FeePaymentAllocation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Current month
        |--------------------------------------------------------------------------
        */
        $today = Carbon::now();

        $currentMonthDate = $today->copy()->startOfMonth();

        $currentMonth = $currentMonthDate->format('Y-m');

        /*
        |--------------------------------------------------------------------------
        | Dashboard selected month
        |--------------------------------------------------------------------------
        |
        | If user selects a month, show that month.
        | Otherwise automatically show current month.
        |
        */
        $selectedMonth = $request->input(
            'month',
            $currentMonth
        );

        /*
        |--------------------------------------------------------------------------
        | Validate selected month
        |--------------------------------------------------------------------------
        */
        try {
            $selectedMonthDate = Carbon::createFromFormat(
                'Y-m',
                $selectedMonth
            )->startOfMonth();
        } catch (\Exception $e) {
            $selectedMonthDate = $currentMonthDate->copy();
            $selectedMonth = $currentMonth;
        }

        /*
        |--------------------------------------------------------------------------
        | Do not allow future months
        |--------------------------------------------------------------------------
        */
        if ($selectedMonthDate->gt($currentMonthDate)) {
            $selectedMonthDate = $currentMonthDate->copy();
            $selectedMonth = $currentMonth;
        }

        $monthName = $selectedMonthDate->format('F Y');

        /*
        |--------------------------------------------------------------------------
        | Available months for dashboard dropdown
        |--------------------------------------------------------------------------
        |
        | Start from earliest payment/admission month and end at current month.
        |
        */
        $firstPayment = FeePayment::orderBy('fee_date', 'asc')->first();

        $firstStudent = EnrolledStudent::whereNotNull(
            'date_of_admission'
        )
        ->orderBy('date_of_admission', 'asc')
        ->first();

        $firstDate = null;

        if ($firstPayment) {
            $firstDate = Carbon::parse(
                $firstPayment->fee_date
            )->startOfMonth();
        }

        if ($firstStudent) {
            $studentDate = Carbon::parse(
                $firstStudent->date_of_admission
            )->startOfMonth();

            if (
                !$firstDate ||
                $studentDate->lt($firstDate)
            ) {
                $firstDate = $studentDate;
            }
        }

        if (!$firstDate) {
            $firstDate = $currentMonthDate->copy();
        }

        /*
        |--------------------------------------------------------------------------
        | Build month dropdown
        |--------------------------------------------------------------------------
        */
        $availableMonths = [];

        $monthPointer = $firstDate->copy();

        while ($monthPointer->lte($currentMonthDate)) {

            $availableMonths[] = [
                'value' => $monthPointer->format('Y-m'),
                'label' => $monthPointer->format('F Y'),
            ];

            $monthPointer->addMonth();
        }

        /*
        |--------------------------------------------------------------------------
        | Total fees collected
        |--------------------------------------------------------------------------
        */
        $totalFeesCollected = FeePayment::where(
            'fee_month',
            $monthName
        )->sum('amount_received');

        /*
        |--------------------------------------------------------------------------
        | Teacher salaries paid
        |--------------------------------------------------------------------------
        */
        $teacherSalariesPaid = TeacherSalaryPayment::where(
            'salary_month',
            $monthName
        )
        ->where(
            'status',
            'Paid'
        )
        ->sum('salary_amount');

        /*
        |--------------------------------------------------------------------------
        | Student fee status
        |--------------------------------------------------------------------------
        */
        $students = EnrolledStudent::latest()->get();

        $defaulters = collect();

        $pendingFees = 0;

        foreach ($students as $student) {

            /*
            |--------------------------------------------------------------------------
            | Student admission month
            |--------------------------------------------------------------------------
            */
            if ($student->date_of_admission) {
                $admissionDate = Carbon::parse(
                    $student->date_of_admission
                )->startOfMonth();
            } else {
                $admissionDate = $selectedMonthDate->copy();
            }

            /*
            |--------------------------------------------------------------------------
            | Student was not enrolled yet
            |--------------------------------------------------------------------------
            */
            if ($admissionDate->gt($selectedMonthDate)) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Current selected month allocation
            |--------------------------------------------------------------------------
            */
            $currentMonthAllocated = FeePaymentAllocation::where(
                'enrolled_student_id',
                $student->id
            )
            ->where(
                'fee_month',
                $monthName
            )
            ->sum('amount_allocated');

            $monthlyFee = (float) $student->fees;

            $currentMonthRemaining = max(
                0,
                $monthlyFee - $currentMonthAllocated
            );

            /*
            |--------------------------------------------------------------------------
            | For the selected month, previous unpaid months
            | are calculated as arrears.
            |--------------------------------------------------------------------------
            */
            $arrears = 0;

            $pointer = $admissionDate->copy();

            while ($pointer->lt($selectedMonthDate)) {

                $previousMonthName =
                    $pointer->format('F Y');

                $allocated = FeePaymentAllocation::where(
                    'enrolled_student_id',
                    $student->id
                )
                ->where(
                    'fee_month',
                    $previousMonthName
                )
                ->sum('amount_allocated');

                $remaining = max(
                    0,
                    $monthlyFee - $allocated
                );

                $arrears += $remaining;

                $pointer->addMonth();
            }

            /*
            |--------------------------------------------------------------------------
            | Total pending amount
            |--------------------------------------------------------------------------
            */
            $studentPending =
                $arrears
                + $currentMonthRemaining;

            $pendingFees += $studentPending;

            /*
            |--------------------------------------------------------------------------
            | Defaulter
            |--------------------------------------------------------------------------
            |
            | A student is a defaulter if selected month's
            | tuition fee is not fully paid.
            |
            */
            if ($studentPending > 0) {
    $student->pending_amount = $studentPending;
    $defaulters->push($student);
}
        }

        /*
        |--------------------------------------------------------------------------
        | Teacher salaries pending
        |--------------------------------------------------------------------------
        */
        $teachers = Teacher::all();

        $teacherSalariesPending = 0;

        foreach ($teachers as $teacher) {

            $alreadyPaid = TeacherSalaryPayment::where(
                'teacher_id',
                $teacher->id
            )
            ->where(
                'salary_month',
                $monthName
            )
            ->where(
                'status',
                'Paid'
            )
            ->exists();

            if (!$alreadyPaid) {

                $weeklyClasses =
                    (float) ($teacher->weekly_classes ?? 0);

                $perClassCharge =
                    (float) ($teacher->per_class_charge ?? 0);

                $expectedSalary =
                    $weeklyClasses
                    * $perClassCharge
                    * 4;

                $teacherSalariesPending +=
                    $expectedSalary;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Miscellaneous charges
        |--------------------------------------------------------------------------
        */
        $miscellaneousCharges = 0;

        /*
        |--------------------------------------------------------------------------
        | Profit / Loss
        |--------------------------------------------------------------------------
        */
        $profitLoss =
            $totalFeesCollected
            - $teacherSalariesPaid
            - $miscellaneousCharges;

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */
        return view(
            'dashboard',
            compact(
                'currentMonth',
                'selectedMonth',
                'monthName',
                'availableMonths',
                'totalFeesCollected',
                'teacherSalariesPaid',
                'pendingFees',
                'teacherSalariesPending',
                'miscellaneousCharges',
                'profitLoss',
                'defaulters'
            )
        );
    }
}