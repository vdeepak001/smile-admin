<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CollegeInfo;
use App\Models\Course;
use App\Models\User;
use App\Http\Requests\Admin\CollegeInfo\StoreCollegeInfoRequest;
use App\Http\Requests\Admin\CollegeInfo\UpdateCollegeInfoRequest;
use App\Mail\CollegeRegistrationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CollegeInfoController extends Controller
{
    /**
     * Display a listing of the college info records.
     */
    public function index()
    {
        return view('admin.college-info.index');
    }

    /**
     * Show the form for creating a new college info record.
     */
    public function create()
    {
        $courses = Course::active()->get();
        return view('admin.college-info.create', compact('courses'));
    }

    /**
     * Store a newly created college info record in storage.
     */
    public function store(StoreCollegeInfoRequest $request)
    {
        $validated = $request->validated();

        // Extract user credentials
        $email = $validated['email'];
        // Generate random password (alphanumeric with at least one uppercase)
        $password = \Illuminate\Support\Str::random(10);
        while (!preg_match('/[A-Z]/', $password)) {
            $password = \Illuminate\Support\Str::random(10);
        }
        
        unset($validated['email']);

        // Extract course IDs
        $courseIds = $validated['course_ids'];
        unset($validated['course_ids']);

        // Generate college code from college name (e.g., "Vikram University" -> "VU")
        if (!empty($validated['college_name']) && empty($validated['college_code'])) {
            $collegeName = $validated['college_name'];
            // Split by spaces and get first letter of each word
            $words = preg_split('/\s+/', trim($collegeName));
            $collegeCode = '';
            foreach ($words as $word) {
                if (!empty($word)) {
                    $collegeCode .= strtoupper(substr($word, 0, 1));
                }
            }
            $validated['college_code'] = $collegeCode;
        }

        // Create user account for college
        $user = User::create([
            'email' => $email,
            'password' => bcrypt($password),
            'role' => 'college',
            'active_status' => true,
            'created_by' => auth()->id(),
        ]);

        // Add user_id to college info
        $validated['user_id'] = $user->id;
        $validated['created_by'] = auth()->id();

        $collegeInfo = CollegeInfo::create($validated);

        // Attach courses
        $collegeInfo->courses()->attach($courseIds);

        // Send registration email with credentials
        Mail::send(new CollegeRegistrationMail($collegeInfo, $email, $password));

        return redirect()
            ->route('college-info.show', $collegeInfo)
            ->withToast([
                'type' => 'success',
                'message' => 'College information created successfully! Registration email sent.',
            ]);
    }

    /**
     * Display the specified college info record.
     */
    public function show(CollegeInfo $collegeInfo)
    {
        $collegeInfo->load(['courses', 'users', 'createdBy', 'updatedBy']);
        return view('admin.college-info.show', compact('collegeInfo'));
    }

    /**
     * Show the form for editing the specified college info record.
     */
    public function edit(CollegeInfo $collegeInfo)
    {
        $courses = Course::active()->get();
        return view('admin.college-info.edit', compact('collegeInfo', 'courses'));
    }

    /**
     * Update the specified college info record in storage.
     */
    public function update(UpdateCollegeInfoRequest $request, CollegeInfo $collegeInfo)
    {
        $validated = $request->validated();

        // Extract user credentials if provided
        $email = $validated['email'] ?? null;
        $password = $validated['password'] ?? null;
        unset($validated['email'], $validated['password']);

        // Extract course IDs
        $courseIds = $validated['course_ids'];
        unset($validated['course_ids']);

        // Generate college code from college name if name is being updated
        if (!empty($validated['college_name']) && empty($validated['college_code'])) {
            $collegeName = $validated['college_name'];
            // Split by spaces and get first letter of each word
            $words = preg_split('/\s+/', trim($collegeName));
            $collegeCode = '';
            foreach ($words as $word) {
                if (!empty($word)) {
                    $collegeCode .= strtoupper(substr($word, 0, 1));
                }
            }
            $validated['college_code'] = $collegeCode;
        }

        // Update user account
        $user = $collegeInfo->user;
        $userData = [];

        if ($email) {
            $userData['email'] = $email;
        }

        if ($password) {
            $userData['password'] = bcrypt($password);
        }

        if (!empty($userData)) {
            $user->update($userData);
        }

        $validated['updated_by'] = auth()->id();
        $collegeInfo->update($validated);

        // Sync courses
        $collegeInfo->courses()->sync($courseIds);

        return redirect()
            ->route('college-info.show', $collegeInfo)
            ->withToast([
                'type' => 'success',
                'message' => 'College information updated successfully!',
            ]);
    }

    /**
     * Remove the specified college info record from storage.
     */
    public function destroy(CollegeInfo $collegeInfo)
    {
        $collegeInfo->delete();

        return redirect()
            ->route('college-info.index')
            ->withToast([
                'type' => 'success',
                'message' => 'College information deleted successfully!',
            ]);
    }

    /**
     * Restore a soft-deleted college info record.
     */
    public function restore($id)
    {
        $collegeInfo = CollegeInfo::onlyTrashed()->findOrFail($id);
        $collegeInfo->restore();

        return redirect()
            ->route('college-info.index')
            ->withToast([
                'type' => 'success',
                'message' => 'College information restored successfully!',
            ]);
    }

    /**
     * Permanently delete a college info record.
     */
    public function forceDelete($id)
    {
        $collegeInfo = CollegeInfo::onlyTrashed()->findOrFail($id);
        $collegeInfo->forceDelete();

        return redirect()
            ->route('college-info.index')
            ->withToast([
                'type' => 'success',
                'message' => 'College information permanently deleted!',
            ]);
    }
}
