<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;

use App\Http\Requests\Admin\Course\StoreCourseRequest;
use App\Http\Requests\Admin\Course\UpdateCourseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the courses.
     */
    public function index()
    {
        return view('admin.courses.index');
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        return view('admin.courses.create');
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $validated = $request->validated();

        $validated['inserted_by'] = Auth::id();
        $validated['inserted_on'] = now();

        // Handle file upload if course_pic is present
        if ($request->hasFile('course_pic')) {
            $validated['course_pic'] = $request->file('course_pic')->store('course-pics', 'public');
        }

        $course = Course::create($validated);

        return redirect()
            ->route('courses.show', $course)
            ->withToast([
                'type' => 'success',
                'message' => 'Course created successfully!',
            ]);
    }

    /**
     * Display the specified course.
     */
    public function show(Course $course)
    {
        $course->load(['topics', 'insertedBy', 'updatedBy']);
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Update the specified course in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $validated = $request->validated();

        $validated['updated_by'] = Auth::id();
        $validated['updated_on'] = now();

        // Handle file upload if course_pic is present
        if ($request->hasFile('course_pic')) {
            // Delete old file if exists
            if ($course->course_pic) {
                Storage::disk('public')->delete($course->course_pic);
            }
            $validated['course_pic'] = $request->file('course_pic')->store('course-pics', 'public');
        } else {
            unset($validated['course_pic']);
        }

        $course->update($validated);

        return redirect()
            ->route('courses.show', $course)
            ->withToast([
                'type' => 'success',
                'message' => 'Course updated successfully!',
            ]);
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(Course $course)
    {
        // Delete course picture if exists
        if ($course->course_pic) {
            Storage::disk('public')->delete($course->course_pic);
        }

        $course->delete();

        return redirect()
            ->route('courses.index')
            ->withToast([
                'type' => 'success',
                'message' => 'Course deleted successfully!',
            ]);
    }

    /**
     * Restore a soft-deleted course.
     */
    public function restore($id)
    {
        $course = Course::onlyTrashed()->findOrFail($id);
        $course->restore();

        return redirect()
            ->route('courses.index')
            ->withToast([
                'type' => 'success',
                'message' => 'Course restored successfully!',
            ]);
    }

    /**
     * Permanently delete a course.
     */
    public function forceDelete($id)
    {
        $course = Course::onlyTrashed()->findOrFail($id);

        // Delete course picture if exists
        if ($course->course_pic) {
            Storage::disk('public')->delete($course->course_pic);
        }

        $course->forceDelete();

        return redirect()
            ->route('courses.index')
            ->withToast([
                'type' => 'success',
                'message' => 'Course permanently deleted!',
            ]);
    }
}
