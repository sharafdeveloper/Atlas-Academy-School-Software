<?php

namespace App\Services;

use App\Models\EnrolledStudent;
use App\Models\FeePaymentAllocation;
use Carbon\Carbon;

class MonthlyFeeService
{
    /**
     * Get all unpaid months from admission month
     * up to the selected month.
     */
    public function getUnpaidMonths(
        EnrolledStudent $student,
        string $selectedMonth
    ): array {
        $selectedDate = Carbon::createFromFormat(
            'Y-m',
            $selectedMonth
        )->startOfMonth();

        /*
        |--------------------------------------------------------------------------
        | Student Admission Month
        |--------------------------------------------------------------------------
        */

        $admissionDate = $student->date_of_admission
            ? Carbon::parse(
                $student->date_of_admission
            )->startOfMonth()
            : $selectedDate->copy();


        /*
        |--------------------------------------------------------------------------
        | Future Admission
        |--------------------------------------------------------------------------
        */

        if ($admissionDate->gt($selectedDate)) {
            return [];
        }


        $months = [];

        $current = $admissionDate->copy();


        /*
        |--------------------------------------------------------------------------
        | Monthly Fee
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | Use base_fee (undiscounted). Discount is applied ONCE,
        | later, inside FeePaymentController. Using the already
        | discounted `fees` column here caused a double-discount
        | bug.
        |
        */

        $tuitionFee = (float) $student->base_fee;


        /*
        |--------------------------------------------------------------------------
        | Loop Through Months
        |--------------------------------------------------------------------------
        */

        while ($current->lte($selectedDate)) {

            /*
            |--------------------------------------------------------------------------
            | Use BOTH formats
            |--------------------------------------------------------------------------
            |
            | Old records may contain:
            |
            | September 2026
            |
            | New records may contain:
            |
            | 2026-09
            |
            */

            $monthName =
                $current->format('F Y');

            $monthKey =
                $current->format('Y-m');


            /*
            |--------------------------------------------------------------------------
            | Amount Allocated
            |--------------------------------------------------------------------------
            */

            $allocated =
                (float) FeePaymentAllocation::where(
                    'enrolled_student_id',
                    $student->id
                )
                ->where(function ($query) use (
                    $monthName,
                    $monthKey
                ) {

                    $query
                        ->where(
                            'fee_month',
                            $monthName
                        )
                        ->orWhere(
                            'fee_month',
                            $monthKey
                        );

                })
                ->sum('amount_allocated');


            /*
            |--------------------------------------------------------------------------
            | Remaining
            |--------------------------------------------------------------------------
            */

            $remaining =
                max(
                    0,
                    $tuitionFee - $allocated
                );


            /*
            |--------------------------------------------------------------------------
            | Add Unpaid Month
            |--------------------------------------------------------------------------
            */

            if ($remaining > 0) {

                $months[] = [

                    'month' =>
                        $monthName,

                    'month_key' =>
                        $monthKey,

                    'tuition_fee' =>
                        $tuitionFee,

                    'allocated' =>
                        $allocated,

                    'remaining' =>
                        $remaining,
                ];
            }


            $current->addMonth();
        }


        return $months;
    }


    /**
     * Get all unpaid fees before the selected month.
     *
     * These become arrears.
     */
    public function getArrears(
        EnrolledStudent $student,
        string $selectedMonth
    ): float {

        $unpaidMonths =
            $this->getUnpaidMonths(
                $student,
                $selectedMonth
            );


        $arrears = 0;


        foreach ($unpaidMonths as $month) {

            /*
            |--------------------------------------------------------------------------
            | Only Previous Months Are Arrears
            |--------------------------------------------------------------------------
            */

            if (
                $month['month_key'] <
                $selectedMonth
            ) {

                $arrears +=
                    $month['remaining'];
            }
        }


        return $arrears;
    }


    /**
     * Get current month's tuition fee.
     */
    public function getCurrentMonthFee(
        EnrolledStudent $student
    ): float {

        /*
        |--------------------------------------------------------------------------
        | IMPORTANT:
        | Use base_fee (undiscounted). Discount is applied ONCE,
        | later, inside FeePaymentController.
        |--------------------------------------------------------------------------
        */

        return (float) $student->base_fee;
    }


    /**
     * Check whether selected month is fully paid.
     */
    public function isCurrentMonthPaid(
        EnrolledStudent $student,
        string $selectedMonth
    ): bool {

        /*
        |--------------------------------------------------------------------------
        | Convert Selected Month
        |--------------------------------------------------------------------------
        */

        $selectedDate =
            Carbon::createFromFormat(
                'Y-m',
                $selectedMonth
            );


        $monthName =
            $selectedDate->format('F Y');


        $monthKey =
            $selectedDate->format('Y-m');


        /*
        |--------------------------------------------------------------------------
        | Get Allocated Amount
        |--------------------------------------------------------------------------
        */

        $allocated =
            (float) FeePaymentAllocation::where(
                'enrolled_student_id',
                $student->id
            )
            ->where(function ($query) use (
                $monthName,
                $monthKey
            ) {

                $query
                    ->where(
                        'fee_month',
                        $monthName
                    )
                    ->orWhere(
                        'fee_month',
                        $monthKey
                    );

            })
            ->sum('amount_allocated');


        /*
        |--------------------------------------------------------------------------
        | Compare With Monthly Fee
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | Use base_fee (undiscounted) to stay consistent with
        | getUnpaidMonths() / getCurrentMonthFee(). Comparing
        | against the discounted `fees` column would mark a
        | month "paid" too early.
        |
        */

        return $allocated >=
            (float) $student->base_fee;
    }


    /**
     * Get total monthly tuition arrears
     * plus current month's fee.
     */
    public function getMonthlyPayable(
        EnrolledStudent $student,
        string $selectedMonth
    ): float {

        /*
        |--------------------------------------------------------------------------
        | Current Fee
        |--------------------------------------------------------------------------
        */

        $currentFee =
            $this->getCurrentMonthFee(
                $student
            );


        /*
        |--------------------------------------------------------------------------
        | Previous Unpaid Fees
        |--------------------------------------------------------------------------
        */

        $arrears =
            $this->getArrears(
                $student,
                $selectedMonth
            );


        /*
        |--------------------------------------------------------------------------
        | Don't Charge Current Month Again
        |--------------------------------------------------------------------------
        */

        if (
            $this->isCurrentMonthPaid(
                $student,
                $selectedMonth
            )
        ) {

            $currentFee = 0;
        }


        return
            $arrears +
            $currentFee;
    }
}