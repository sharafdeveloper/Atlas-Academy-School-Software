<?php

namespace App\Http\Controllers;

use App\Models\FeeStructure;
use Illuminate\Http\Request;

class FeeStructureController extends Controller
{
    /**
     * Display fee structures.
     */
    public function index()
    {
        $feeStructures = FeeStructure::orderBy('class')
            ->orderBy('board')
            ->orderBy('number_of_subjects')
            ->get();

        return view(
            'fee_structures.index',
            compact('feeStructures')
        );
    }


    /**
     * Show create form.
     */
    public function create()
    {
        return view('fee_structures.create');
    }


    /**
     * Store new fee structure.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class' => 'required|in:IX,X,XI,XII',

            'board' => 'required|in:Karachi Board,Federal Board',

            'number_of_subjects' =>
                'required|integer|min:1|max:6',

            'monthly_fee' =>
                'required|numeric|min:0',
        ]);


        FeeStructure::create($validated);


        return redirect()
            ->route('fee-structures.index')
            ->with(
                'success',
                'Fee structure added successfully.'
            );
    }


    /**
     * Show edit form.
     */
    public function edit(FeeStructure $feeStructure)
    {
        return view(
            'fee_structures.edit',
            compact('feeStructure')
        );
    }


    /**
     * Update fee structure.
     */
    public function update(
        Request $request,
        FeeStructure $feeStructure
    ) {

        $validated = $request->validate([
            'class' => 'required|in:IX,X,XI,XII',

            'board' => 'required|in:Karachi Board,Federal Board',

            'number_of_subjects' =>
                'required|integer|min:1|max:6',

            'monthly_fee' =>
                'required|numeric|min:0',
        ]);


        $feeStructure->update($validated);


        return redirect()
            ->route('fee-structures.index')
            ->with(
                'success',
                'Fee structure updated successfully.'
            );
    }


    /**
     * Delete fee structure.
     */
    public function destroy(FeeStructure $feeStructure)
    {
        $feeStructure->delete();


        return redirect()
            ->route('fee-structures.index')
            ->with(
                'success',
                'Fee structure deleted successfully.'
            );
    }
}