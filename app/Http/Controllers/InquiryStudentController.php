<?php

namespace App\Http\Controllers;

use App\Models\InquiryStudent;
use Illuminate\Http\Request;

class InquiryStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inquiries = InquiryStudent::latest()->get();

        return view('inquiry_students.index', compact('inquiries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inquiry_students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'class' => 'required|in:IX,X,XI,XII',
            'board' => 'required|in:Federal Board,Karachi Board',
            'phone_number' => 'required|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'status' => 'required|in:New,Follow Up,Joined,Not Interested',
            'notes' => 'nullable|string',
        ]);

        InquiryStudent::create([
            'name' => $request->name,
            'class' => $request->class,
            'board' => $request->board,
            'phone_number' => $request->phone_number,
            'whatsapp_number' => $request->whatsapp_number,
            'status' => $request->status,
            'remarks' => $request->notes,
            'inquiry_date' => now()->toDateString(),
        ]);

        return redirect()
            ->route('inquiry-students.index')
            ->with('success', 'Inquiry student added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inquiryStudent = InquiryStudent::findOrFail($id);

        return view('inquiry_students.show', compact('inquiryStudent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $inquiryStudent = InquiryStudent::findOrFail($id);

        return view('inquiry_students.edit', compact('inquiryStudent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inquiry = InquiryStudent::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'class' => 'required|in:IX,X,XI,XII',
            'board' => 'required|in:Federal Board,Karachi Board',
            'phone_number' => 'required|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'status' => 'required|in:New,Follow Up,Joined,Not Interested',
            'notes' => 'nullable|string',
        ]);

        $inquiry->update([
            'name' => $request->name,
            'class' => $request->class,
            'board' => $request->board,
            'phone_number' => $request->phone_number,
            'whatsapp_number' => $request->whatsapp_number,
            'status' => $request->status,
            'remarks' => $request->notes,
        ]);

        return redirect()
            ->route('inquiry-students.index')
            ->with('success', 'Inquiry student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inquiry = InquiryStudent::findOrFail($id);

        $inquiry->delete();

        return redirect()
            ->route('inquiry-students.index')
            ->with('success', 'Inquiry student deleted successfully.');
    }
}
