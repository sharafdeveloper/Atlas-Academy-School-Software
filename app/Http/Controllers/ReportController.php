<?php

namespace App\Http\Controllers;

use App\Models\FeePayment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Shared filter logic for Fee Query.
     */
    private function buildFeeQuery(Request $request)
    {
        $query = FeePayment::with('enrolledStudent');

        // 1. Search student name or code
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->whereHas('enrolledStudent', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('student_code', 'like', "%{$search}%");
            });
        }

        // 2. Filter by Fee Month
        if ($request->filled('month')) {
            $query->where('fee_month', $request->month);
        }

        // 3. Filter by Collector
        if ($request->filled('collected_by')) {
            $query->where('collected_by', $request->collected_by);
        }

        return $query;
    }

    /**
     * Web view for fees history.
     */
    public function feesHistory(Request $request)
    {
        $query = $this->buildFeeQuery($request);

        // Summary metrics
        $totalPayments = (clone $query)->count();
        $totalAmountCollected = (clone $query)->sum('amount_received');

        // Paginated records for table
        $payments = $query->latest('id')
            ->paginate(20)
            ->withQueryString();

        // Get unique collectors for dropdown
        $collectors = FeePayment::whereNotNull('collected_by')
            ->distinct()
            ->pluck('collected_by');

        // Get unique months from database
        $months = FeePayment::whereNotNull('fee_month')
            ->distinct()
            ->pluck('fee_month');

        return view('reports.fees', compact(
            'payments',
            'totalPayments',
            'totalAmountCollected',
            'collectors',
            'months'
        ));
    }

    /**
     * Alias if route points to feeReport.
     */
    public function feeReport(Request $request)
    {
        return $this->feesHistory($request);
    }

    /**
     * Export to PDF.
     */
    public function exportFeePdf(Request $request)
    {
        $query = $this->buildFeeQuery($request);

        $payments = $query->latest('id')->get();
        $totalPayments = $payments->count();
        $totalAmountCollected = $payments->sum('amount_received');

        $selectedMonth = $request->filled('month') ? $request->month : 'All Months';
        $collectorName = $request->filled('collected_by') ? $request->collected_by : 'Everyone';

        $pdf = Pdf::loadView('reports.fees_pdf', compact(
            'payments',
            'totalPayments',
            'totalAmountCollected',
            'selectedMonth',
            'collectorName'
        ))->setPaper('a4', 'portrait');

        $filename = 'fees-report-' . strtolower(str_replace(' ', '-', $selectedMonth)) . '.pdf';

        return $pdf->download($filename);
    }
}