<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\TeacherSalaryPayment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TeacherSalaryPaymentController extends Controller
{
    /**
     * Show salary payment form.
     */
    public function create(string $teacher)
    {
        $teacher = Teacher::findOrFail($teacher);

        $currentMonth = Carbon::now()->format('F Y');

        // Check whether current month's salary is already paid
        $alreadyPaid = TeacherSalaryPayment::where('teacher_id', $teacher->id)
            ->where('salary_month', $currentMonth)
            ->where('status', 'Paid')
            ->exists();

        $weeklySalary =
            $teacher->weekly_classes *
            $teacher->per_class_charge;

        $monthlySalary = $weeklySalary * 4;

        return view(
            'teacher_salary_payments.create',
            compact(
                'teacher',
                'currentMonth',
                'alreadyPaid',
                'weeklySalary',
                'monthlySalary'
            )
        );
    }


    /**
     * Store salary payment.
     */
    public function store(Request $request, string $teacher)
    {
        $teacher = Teacher::findOrFail($teacher);

        $currentMonth = Carbon::now()->format('F Y');

        // Prevent duplicate salary payment
        $alreadyPaid = TeacherSalaryPayment::where('teacher_id', $teacher->id)
            ->where('salary_month', $currentMonth)
            ->where('status', 'Paid')
            ->exists();

        if ($alreadyPaid) {

            return redirect()
                ->route('teachers.show', $teacher->id)
                ->with('error', 'This teacher salary has already been paid for ' . $currentMonth . '.');
        }


        $weeklySalary =
            $teacher->weekly_classes *
            $teacher->per_class_charge;

        $monthlySalary =
            $weeklySalary * 4;


        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);


        TeacherSalaryPayment::create([

            'teacher_id' => $teacher->id,

            'salary_month' => $currentMonth,

            'weekly_classes' =>
                $teacher->weekly_classes,

            'per_class_charge' =>
                $teacher->per_class_charge,

            'salary_amount' =>
                $monthlySalary,

            'payment_date' =>
                Carbon::now()->toDateString(),

            'payment_time' =>
                Carbon::now()->format('H:i:s'),

            'status' =>
                'Paid',

            'notes' =>
                $request->notes,

        ]);


        return redirect()
            ->route('teachers.show', $teacher->id)
            ->with(
                'success',
                'Salary of Rs. ' .
                number_format($monthlySalary, 2) .
                ' paid successfully for ' .
                $currentMonth . '.'
            );
    }
}
