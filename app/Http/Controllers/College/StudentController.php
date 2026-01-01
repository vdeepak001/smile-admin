<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Degree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\Student\UpdateStudentRequest;

class StudentController extends Controller
{
    public function show(Student $student)
    {
        // Verify student belongs to this college
        if ($student->user->college_id !== Auth::user()->collegeAccount->college_id) {
            abort(403, 'Unauthorized access to this student.');
        }

        $student->load(['user', 'degree']);
        
        // Get assigned courses from assigned_courses table, filtering for college-type courses only
        $assignedCourses = \App\Models\AssignedCourse::where('student_id', $student->user_id)
            ->with(['course'])
            ->whereHas('course', function($query) {
                $query->where('course_type', 'college');
            })
            ->get();

        return view('college.students.show', compact('student', 'assignedCourses'));
    }

    public function edit(Student $student)
    {
        // Verify student belongs to this college
        if ($student->user->college_id !== Auth::user()->collegeAccount->college_id) {
            abort(403, 'Unauthorized access to this student.');
        }

        $student->load(['user', 'degree']);
        $degrees = Degree::where('active_status', true)->orderBy('name')->get();

        return view('college.students.edit', compact('student', 'degrees'));
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        // Verify student belongs to this college
        if ($student->user->college_id !== Auth::user()->collegeAccount->college_id) {
            abort(403, 'Unauthorized access to this student.');
        }

        // Update student information
        $student->update([
            'degree_id' => $request->degree_id,
            'specialization' => $request->specialization,
            'year_of_study' => $request->year_of_study,
            'start_year' => $request->start_year,
            'end_year' => $request->end_year,
            'enrollment_no' => $request->enrollment_no,
            'roll_number' => $request->roll_number,
            'guardian_name' => $request->guardian_name,
            'date_of_birth' => $request->date_of_birth,
            'active_status' => $request->boolean('active_status', true),
            'updated_by' => Auth::id(),
        ]);

        // Update user information
        $student->user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'active_status' => $request->boolean('active_status', true),
            'updated_by' => Auth::id(),
        ]);

        return redirect()
            ->route('college.students.index')
            ->with('success', 'Student updated successfully!');
    }
}
