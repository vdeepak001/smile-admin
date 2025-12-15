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

        // Handle multiple attachments upload
        if ($request->hasFile('attachments')) {
            $attachments = [];
            foreach ($request->file('attachments') as $file) {
                $originalName = $file->getClientOriginalName();
                $storedPath = $file->store('topic-attachments', 'public');
                $attachments[] = [
                    'path' => $storedPath,
                    'original_name' => $originalName
                ];
            }
            $validated['attachment'] = json_encode($attachments);
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

        // Handle multiple attachments upload
        if ($request->hasFile('attachments')) {
            // Delete old attachments
            if ($courseTopic->attachment) {
                $oldAttachments = json_decode($courseTopic->attachment, true);
                if (is_array($oldAttachments)) {
                    foreach ($oldAttachments as $oldFile) {
                        Storage::disk('public')->delete($oldFile['path']);
                    }
                }
            }
            
            $attachments = [];
            foreach ($request->file('attachments') as $file) {
                $originalName = $file->getClientOriginalName();
                $storedPath = $file->store('topic-attachments', 'public');
                $attachments[] = [
                    'path' => $storedPath,
                    'original_name' => $originalName
                ];
            }
            $validated['attachment'] = json_encode($attachments);
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

        // Delete attachments if they exist
        if ($courseTopic->attachment) {
            $attachments = json_decode($courseTopic->attachment, true);
            if (is_array($attachments)) {
                foreach ($attachments as $file) {
                    Storage::disk('public')->delete($file['path']);
                }
            }
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
