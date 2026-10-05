<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display teachers.
     */
    public function index(Request $request)
    {
        $query = Teacher::query();

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('phone_number', 'like', '%' . $search . '%')
                  ->orWhere('whatsapp_number', 'like', '%' . $search . '%');

            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $teachers = $query
            ->latest()
            ->get();

        return view(
            'teachers.index',
            compact('teachers')
        );
    }


    /**
     * Show create form.
     */
    public function create()
    {
        return view('teachers.create');
    }


    /**
     * Store teacher.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',

            'phone_number' =>
                'nullable|string|max:20',

            'whatsapp_number' =>
                'nullable|string|max:20',

            'weekly_classes' =>
                'required|integer|min:0',

            'per_class_charge' =>
                'required|numeric|min:0',

            'joining_date' =>
                'nullable|date',

            'status' =>
                'required|in:Active,Inactive',
        ]);


        Teacher::create([
            'name' =>
                $request->name,

            'phone_number' =>
                $request->phone_number,

            'whatsapp_number' =>
                $request->whatsapp_number,

            'weekly_classes' =>
                $request->weekly_classes,

            'per_class_charge' =>
                $request->per_class_charge,

            'joining_date' =>
                $request->joining_date,

            'status' =>
                $request->status,
        ]);


        return redirect()
            ->route('teachers.index')
            ->with(
                'success',
                'Teacher added successfully.'
            );
    }


    /**
     * Display teacher.
     */
    public function show(string $id)
    {
        $teacher = Teacher::findOrFail($id);

        return view(
            'teachers.show',
            compact('teacher')
        );
    }


    /**
     * Show edit form.
     */
    public function edit(string $id)
    {
        $teacher = Teacher::findOrFail($id);

        return view(
            'teachers.edit',
            compact('teacher')
        );
    }


    /**
     * Update teacher.
     */
    public function update(
        Request $request,
        string $id
    ) {
        $teacher = Teacher::findOrFail($id);

        $request->validate([
            'name' =>
                'required|string|max:255',

            'phone_number' =>
                'nullable|string|max:20',

            'whatsapp_number' =>
                'nullable|string|max:20',

            'weekly_classes' =>
                'required|integer|min:0',

            'per_class_charge' =>
                'required|numeric|min:0',

            'joining_date' =>
                'nullable|date',

            'status' =>
                'required|in:Active,Inactive',
        ]);


        $teacher->update([
            'name' =>
                $request->name,

            'phone_number' =>
                $request->phone_number,

            'whatsapp_number' =>
                $request->whatsapp_number,

            'weekly_classes' =>
                $request->weekly_classes,

            'per_class_charge' =>
                $request->per_class_charge,

            'joining_date' =>
                $request->joining_date,

            'status' =>
                $request->status,
        ]);


        return redirect()
            ->route('teachers.index')
            ->with(
                'success',
                'Teacher updated successfully.'
            );
    }


    /**
     * Delete teacher.
     */
    public function destroy(string $id)
    {
        $teacher = Teacher::findOrFail($id);

        $teacher->delete();

        return redirect()
            ->route('teachers.index')
            ->with(
                'success',
                'Teacher deleted successfully.'
            );
    }
}