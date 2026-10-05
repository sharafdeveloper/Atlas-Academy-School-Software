<?php

namespace App\Http\Controllers;

use App\Models\EnrolledStudent;
use App\Models\FeePayment;
use App\Models\FeePaymentAllocation;
use App\Services\MonthlyFeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FeePaymentController extends Controller
{
    protected MonthlyFeeService $monthlyFeeService;

    public function __construct(MonthlyFeeService $monthlyFeeService)
    {
        $this->monthlyFeeService = $monthlyFeeService;
    }

    /**
     * Show fee collection form.
     */
    public function create($studentId)
    {
        $student = EnrolledStudent::findOrFail($studentId);

        $currentDate = Carbon::now()->startOfMonth();

        $selectedMonth = $currentDate->format('Y-m');
        $currentMonth = $currentDate->format('F Y');

        /*
        |--------------------------------------------------------------------------
        | Unpaid Months
        |--------------------------------------------------------------------------
        */
        $unpaidMonths = $this->monthlyFeeService->getUnpaidMonths(
            $student,
            $selectedMonth
        );

        /*
        |--------------------------------------------------------------------------
        | Arrears
        |--------------------------------------------------------------------------
        */
        $arrears = $this->monthlyFeeService->getArrears(
            $student,
            $selectedMonth
        );

        /*
        |--------------------------------------------------------------------------
        | Tuition Fee
        |--------------------------------------------------------------------------
        */
        $tuitionFee = (float) $this->monthlyFeeService->getCurrentMonthFee(
            $student
        );

        /*
        |--------------------------------------------------------------------------
        | Discount
        |--------------------------------------------------------------------------
        */
        $discount = (float) ($student->discount ?? 0);

        /*
        |--------------------------------------------------------------------------
        | Previous Advance
        |--------------------------------------------------------------------------
        */
        $previousPayment = $student->feePayments()
            ->latest('id')
            ->first();

        $previousAdvance = (float) (
            $previousPayment->advance_amount ?? 0
        );

        /*
        |--------------------------------------------------------------------------
        | Admission Fee
        |--------------------------------------------------------------------------
        */
        $hasPreviousPayment = $student->feePayments()->exists();

        $admissionFee = $hasPreviousPayment
            ? 0
            : (float) ($student->admission_fee ?? 0);

        /*
        |--------------------------------------------------------------------------
        | Admission Fee Waiver
        |--------------------------------------------------------------------------
        */
        $standardAdmissionFee = 1000;

        $admissionFeeWaiver = $hasPreviousPayment
            ? 0
            : max(
                0,
                $standardAdmissionFee - $admissionFee
            );

        /*
        |--------------------------------------------------------------------------
        | Total Fees Before Discount
        |--------------------------------------------------------------------------
        */
        $totalFees =
            $admissionFee
            + $tuitionFee
            + $arrears
            - $previousAdvance;

        $totalFees = max(0, $totalFees);

        /*
        |--------------------------------------------------------------------------
        | Apply Discount
        |--------------------------------------------------------------------------
        */
        $discount = min($discount, $totalFees);

        /*
        |--------------------------------------------------------------------------
        | Net Payable
        |--------------------------------------------------------------------------
        */
        $netPayable = max(
            0,
            $totalFees - $discount
        );

        /*
        |--------------------------------------------------------------------------
        | Check Current Month Payment
        |--------------------------------------------------------------------------
        */
        $currentMonthPaid = collect($unpaidMonths)
            ->contains(function ($month) use ($selectedMonth) {
                return $month['month_key'] === $selectedMonth;
            }) === false;

        if (
            $currentMonthPaid &&
            $arrears <= 0 &&
            $admissionFee <= 0 &&
            $previousAdvance <= 0
        ) {
            return redirect()
                ->route('enrolled-students.index')
                ->with(
                    'error',
                    "Current month's fee has already been paid."
                );
        }

        return view(
            'fee_payments.create',
            compact(
                'student',
                'currentMonth',
                'tuitionFee',
                'discount',
                'admissionFee',
                'admissionFeeWaiver',
                'arrears',
                'previousAdvance',
                'totalFees',
                'netPayable',
                'unpaidMonths'
            )
        );
    }

    /**
     * Store fee payment.
     */
    public function store(Request $request, $studentId)
    {
        $student = EnrolledStudent::findOrFail($studentId);

        /*
        |--------------------------------------------------------------------------
        | Validate Amount
        |--------------------------------------------------------------------------
        */
        $request->validate([
            'amount_received' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Current Month
        |--------------------------------------------------------------------------
        */
        $currentDate = Carbon::now()->startOfMonth();

        /*
        |--------------------------------------------------------------------------
        | IMPORTANT
        |--------------------------------------------------------------------------
        | Database month format will always be:
        |
        | 2026-09
        | 2026-10
        | 2026-11
        |
        |--------------------------------------------------------------------------
        */
        $selectedMonth = $currentDate->format('Y-m');
        $currentMonth = $currentDate->format('F Y');

        /*
        |--------------------------------------------------------------------------
        | Unpaid Months
        |--------------------------------------------------------------------------
        */
        $unpaidMonths = $this->monthlyFeeService->getUnpaidMonths(
            $student,
            $selectedMonth
        );

        /*
        |--------------------------------------------------------------------------
        | Arrears
        |--------------------------------------------------------------------------
        */
        $arrears = $this->monthlyFeeService->getArrears(
            $student,
            $selectedMonth
        );

        /*
        |--------------------------------------------------------------------------
        | Tuition Fee
        |--------------------------------------------------------------------------
        */
        $tuitionFee = (float) $this->monthlyFeeService->getCurrentMonthFee(
            $student
        );

        /*
        |--------------------------------------------------------------------------
        | Discount
        |--------------------------------------------------------------------------
        */
        $discount = (float) ($student->discount ?? 0);

        /*
        |--------------------------------------------------------------------------
        | Previous Advance
        |--------------------------------------------------------------------------
        */
        $previousPayment = $student->feePayments()
            ->latest('id')
            ->first();

        $previousAdvance = (float) (
            $previousPayment->advance_amount ?? 0
        );

        /*
        |--------------------------------------------------------------------------
        | Admission Fee
        |--------------------------------------------------------------------------
        */
        $hasPreviousPayment = $student->feePayments()->exists();

        $admissionFee = $hasPreviousPayment
            ? 0
            : (float) ($student->admission_fee ?? 0);

        /*
        |--------------------------------------------------------------------------
        | Admission Fee Waiver
        |--------------------------------------------------------------------------
        */
        $standardAdmissionFee = 1000;

        $admissionFeeWaiver = $hasPreviousPayment
            ? 0
            : max(
                0,
                $standardAdmissionFee - $admissionFee
            );

        /*
        |--------------------------------------------------------------------------
        | Total Fees Before Discount
        |--------------------------------------------------------------------------
        */
        /*
| Total Fees = pure sum. Previous Advance ismein shaamil NAHI hai.
*/
$totalFees = $admissionFee + $tuitionFee + $arrears;
$totalFees = max(0, $totalFees);

$discount = min($discount, $totalFees);

/*
| Pehle Discount minus, phir Previous Advance minus — tab Net Payable banega
*/
$payableAfterDiscount = max(0, $totalFees - $discount);

$netPayable = max(0, $payableAfterDiscount - $previousAdvance);

        /*
        |--------------------------------------------------------------------------
        | Amount Received
        |--------------------------------------------------------------------------
        */
        $amountReceived = (float) $request->amount_received;

        /*
        |--------------------------------------------------------------------------
        | No Partial Payment
        |--------------------------------------------------------------------------
        */
       // Purana:
$remainingAmount = 0;

// Naya:
$remainingAmount = max(0, $netPayable - $amountReceived);

        /*
        |--------------------------------------------------------------------------
        | New Advance
        |--------------------------------------------------------------------------
        */
        $advanceAmount = max(
            0,
            $amountReceived - $netPayable
        );

        $remainingAmount = 0;

        /*
        |--------------------------------------------------------------------------
        | Database Transaction
        |--------------------------------------------------------------------------
        */
        $payment = DB::transaction(function () use (
            $student,
            $currentMonth,
            $currentDate,
            $selectedMonth,
            $tuitionFee,
            $discount,
            $admissionFee,
            $admissionFeeWaiver,
            $arrears,
            $amountReceived,
            $remainingAmount,
            $advanceAmount,
            $unpaidMonths,
            $previousAdvance,
            $totalFees,
            $netPayable
        ) {

            /*
            |--------------------------------------------------------------------------
            | Create Payment
            |--------------------------------------------------------------------------
            */
            $payment = FeePayment::create([
                'enrolled_student_id' => $student->id,

                /*
                | Keep payment record readable as "September 2026"
                */
                'fee_month' => $currentMonth,

                'fee_date' => $currentDate->format('Y-m-d'),

                'fee_time' => Carbon::now()->format('H:i:s'),

                'tuition_fee' => $tuitionFee,

                'discount' => $discount,

                'admission_fee' => $admissionFee,

                'admission_fee_waiver' => $admissionFeeWaiver,

                'arrears' => $arrears,

                'previous_advance' => $previousAdvance,

                'total_fees' => $totalFees,

                'net_payable' => $netPayable,

                'amount_received' => $amountReceived,

                'remaining_amount' => $remainingAmount,

                'advance_amount' => $advanceAmount,

                'collected_by' => auth()->user()->name ?? 'System',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Amount Available For Tuition
            |--------------------------------------------------------------------------
            */
            $tuitionAmountAvailable =
                max(
                    0,
                    $amountReceived - $admissionFee
                );

            /*
            |--------------------------------------------------------------------------
            | Discount Remaining
            |--------------------------------------------------------------------------
            */
            $discountRemaining = $discount;

            /*
            |--------------------------------------------------------------------------
            | Allocate Payment
            |--------------------------------------------------------------------------
            */
            foreach ($unpaidMonths as $month) {

                if ($tuitionAmountAvailable <= 0 && $discountRemaining <= 0) {
                    break;
                }

                $remainingForMonth =
                    (float) $month['remaining'];

                if ($remainingForMonth <= 0) {
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Apply Discount
                |--------------------------------------------------------------------------
                */
                $monthDiscount = min(
                    $discountRemaining,
                    $remainingForMonth
                );

                $discountRemaining -= $monthDiscount;

                /*
                |--------------------------------------------------------------------------
                | Remaining After Discount
                |--------------------------------------------------------------------------
                */
                $effectiveRemaining =
                    max(
                        0,
                        $remainingForMonth - $monthDiscount
                    );

                /*
                |--------------------------------------------------------------------------
                | Cash Allocation
                |--------------------------------------------------------------------------
                */
                $amountToAllocate = min(
                    $tuitionAmountAvailable,
                    $effectiveRemaining
                );

                /*
                |--------------------------------------------------------------------------
                | Total Coverage
                |--------------------------------------------------------------------------
                */
                $totalMonthCoverage =
                    $monthDiscount
                    + $amountToAllocate;

                /*
                |--------------------------------------------------------------------------
                | SAVE ALLOCATION
                |--------------------------------------------------------------------------
                |
                | IMPORTANT:
                | We now save month_key (Y-m), NOT month name.
                |
                | Example:
                | 2026-09
                |
                |--------------------------------------------------------------------------
                */
                if ($totalMonthCoverage > 0) {

                    FeePaymentAllocation::create([
                        'fee_payment_id' =>
                            $payment->id,

                        'enrolled_student_id' =>
                            $student->id,

                        'fee_month' =>
                            $month['month_key'],

                        'amount_allocated' =>
                            $totalMonthCoverage,
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Reduce Available Cash
                |--------------------------------------------------------------------------
                */
                $tuitionAmountAvailable -= $amountToAllocate;
            }

            return $payment;
        });

        /*
        |--------------------------------------------------------------------------
        | Redirect To Receipt
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route(
                'fee-payments.show',
                $payment->id
            )
            ->with(
                'success',
                'Fee collected successfully.'
            );
    }

    /**
     * Show payment receipt.
     */
    public function show($id)
    {
        $payment = FeePayment::with([
            'enrolledStudent',
            'allocations',
        ])->findOrFail($id);

        return view(
            'fee_payments.show',
            compact('payment')
        );
    }
}