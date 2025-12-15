<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseTopic;
use App\Models\Course;
use App\Http\Requests\Admin\CourseTopic\StoreCourseTopicRequest;
use App\Http\Requests\Admin\CourseTopic\UpdateCourseTopicRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CourseTopicController extends Controller
{
    /**
     * Display a listing of the course topics.
     */
    public function index()
    {
        return view('admin.course-topics.index');
    }

    /**
     * Show the form for creating a new course topic.
     */
    public function create()
    {
        $courses = Course::where('active_status', true)
            ->where('course_type', 'college')
            ->orderBy('course_name')
            ->get();
        
        return view('admin.course-topics.create', compact('courses'));
    }

    /**
     * Store a newly created course topic in storage.
     */
    public function store(StoreCourseTopicRequest $request)
    {
        $validated = $request->validated();

        $validated['inserted_by'] = Auth::id();
        $validated['inserted_on'] = now();

        // Handle topic picture upload
        if ($request->hasFile('topic_pic')) {
            $validated['topic_pic'] = $request->file('topic_pic')->store('topic-pics', 'public');
        }

        // Handle attachment upload
        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('topic-attachments', 'public');
        }

        $topic = CourseTopic::create($validated);

        return redirect()
            ->route('course-topics.show', $topic)
            ->withToast([
                'type' => 'success',
                'message' => 'Course topic created successfully!',
            ]);
    }

    /**
     * Display the specified course topic.
     */
    public function show(CourseTopic $courseTopic)
    {
        $courseTopic->load(['course', 'insertedBy', 'updatedBy', 'questions']);
        return view('admin.course-topics.show', compact('courseTopic'));
    }

    /**
     * Show the form for editing the specified course topic.
     */
    public function edit(CourseTopic $courseTopic)
    {
        $courses = Course::where('active_status', true)
            ->where('course_type', 'college')
            ->orderBy('course_name')
            ->get();
        
        return view('admin.course-topics.edit', compact('courseTopic', 'courses'));
    }

    /**
     * Update the specified course topic in storage.
     */
    public function update(UpdateCourseTopicRequest $request, CourseTopic $courseTopic)
    {
        $validated = $request->validated();

        $validated['updated_by'] = Auth::id();
        $validated['updated_on'] = now();

        // Handle topic picture upload
        if ($request->hasFile('topic_pic')) {
            if ($courseTopic->topic_pic) {
                Storage::disk('public')->delete($courseTopic->topic_pic);
            }
            $validated['topic_pic'] = $request->file('topic_pic')->store('topic-pics', 'public');
        } else {
            unset($validated['topic_pic']);
        }

        // Handle attachment upload
        if ($request->hasFile('attachment')) {
            if ($courseTopic->attachment) {
                Storage::disk('public')->delete($courseTopic->attachment);
            }
            $validated['attachment'] = $request->file('attachment')->store('topic-attachments', 'public');
        } else {
            unset($validated['attachment']);
        }

        $courseTopic->update($validated);

        return redirect()
            ->route('course-topics.show', $courseTopic)
            ->withToast([
                'type' => 'success',
                'message' => 'Course topic updated successfully!',
            ]);
    }

    /**
     * Remove the specified course topic from storage.
     */
    public function destroy(CourseTopic $courseTopic)
    {
        $courseTopic->delete();

        return redirect()
            ->route('course-topics.index')
            ->withToast([
                'type' => 'success',
                'message' => 'Course topic deleted successfully!',
            ]);
    }

    /**
     * Restore a soft-deleted course topic.
     */
    public function restore($id)
    {
        $courseTopic = CourseTopic::onlyTrashed()->findOrFail($id);
        $courseTopic->restore();

        return redirect()
            ->route('course-topics.index')
            ->withToast([
                'type' => 'success',
                'message' => 'Course topic restored successfully!',
            ]);
    }

    /**
     * Permanently delete a course topic.
     */
    public function forceDelete($id)
    {
        $courseTopic = CourseTopic::onlyTrashed()->findOrFail($id);

        // Delete files if they exist
        if ($courseTopic->topic_pic) {
            Storage::disk('public')->delete($courseTopic->topic_pic);
        }
        if ($courseTopic->attachment) {
            Storage::disk('public')->delete($courseTopic->attachment);
        }

        $courseTopic->forceDelete();

        return redirect()
            ->route('course-topics.index')
            ->withToast([
                'type' => 'success',
                'message' => 'Course topic permanently deleted!',
            ]);
    }
}
