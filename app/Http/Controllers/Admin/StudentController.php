<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\CollegeInfo;
use App\Models\Course;
use App\Models\Degree;
use App\Models\AssignedCourse;
use App\Http\Requests\Admin\Student\StoreStudentRequest;
use App\Http\Requests\Admin\Student\UpdateStudentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentRegistrationMail;


class StudentController extends Controller
{
    public function index()
    {
        return view('admin.students.index');
    }

    public function create()
    {
        $colleges = CollegeInfo::where('active_status', true)->get();
        $courses = Course::where('active_status', true)->get();
        $degrees = Degree::where('active_status', true)->get();
        // Get next user ID safely (ignoring scopes to handle soft deletes accurately for ID generation prediction)
        $nextUserId = DB::table('users')->max('id') + 1;
        return view('admin.students.create', compact('colleges', 'courses', 'degrees', 'nextUserId'));
    }

    public function store(StoreStudentRequest $request)
    {
        $validated = $request->validated();
        $generatedPassword = \Illuminate\Support\Str::random(10);

        DB::transaction(function () use ($validated, $generatedPassword) {
            // Create User
            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'password' => bcrypt($generatedPassword),
                'phone_number' => $validated['phone_number'] ?? null,
                'college_id' => $validated['college_id'],
                'role' => User::ROLE_STUDENT,
                'active_status' => $validated['active_status'] ?? true,
                'created_by' => auth()->id(),
            ]);


            $enrollmentNo = 'ENRO_' . $validated['college_id'] . '_' . $user->id;
            \Illuminate\Support\Facades\Log::info('Creating Student', [
                'college_id' => $validated['college_id'],
                'user_id' => $user->id,
                'generated_enrollment_no' => $enrollmentNo
            ]);

            // Create Student
            $student = Student::create([
                'user_id' => $user->id,
                'degree_id' => $validated['degree_id'] ?? null,
                'specialization' => $validated['specialization'] ?? null,
                'year_of_study' => $validated['year_of_study'] ?? null,
                'enrollment_no' => $enrollmentNo,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'active_status' => $validated['active_status'] ?? true,
                'created_by' => auth()->id(),
            ]);

            // Assign courses if provided
            if (!empty($validated['course_ids'])) {
                foreach ($validated['course_ids'] as $courseId) {
                    AssignedCourse::create([
                        'student_id' => $user->id,
                        'course_id' => $courseId,
                        'completion_status' => 'not_started',
                        'assigned_by' => auth()->id(),
                        'assigned_on' => now(),
                    ]);
                }
            }

             // Send registration email with credentials
             Mail::send(new StudentRegistrationMail($student, $validated['email'], $generatedPassword));
        });

        return redirect()
            ->route('students.index')
            ->withToast([
                'type' => 'success',
                'message' => 'Student created successfully!',
            ]);
    }

    public function show(Student $student)
    {
        $student->load(['user.college', 'createdBy', 'updatedBy', 'courses', 'degree']);
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $student->load(['user', 'courses']);
        $colleges = CollegeInfo::where('active_status', true)->get();
        $courses = Course::where('active_status', true)->get();
        $degrees = Degree::where('active_status', true)->get();
        return view('admin.students.edit', compact('student', 'colleges', 'courses', 'degrees'));
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $student) {
            // Update User
            $userData = [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone_number'] ?? null,
                'college_id' => $validated['college_id'],
                'active_status' => $validated['active_status'] ?? true,
                'updated_by' => auth()->id(),
            ];

            $student->user->update($userData);

            // Update Student
            $student->update([
                'degree_id' => $validated['degree_id'] ?? null,
                'specialization' => $validated['specialization'] ?? null,
                'year_of_study' => $validated['year_of_study'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'active_status' => $validated['active_status'] ?? true,
                'updated_by' => auth()->id(),
            ]);

            // Sync courses
            // First, permanently delete existing course assignments to avoid unique constraint violations
            AssignedCourse::where('student_id', $student->user_id)->forceDelete();
            
            // Then, create new assignments if provided
            if (!empty($validated['course_ids'])) {
                foreach ($validated['course_ids'] as $courseId) {
                    AssignedCourse::create([
                        'student_id' => $student->user_id,
                        'course_id' => $courseId,
                        'completion_status' => 'not_started',
                        'assigned_by' => auth()->id(),
                        'assigned_on' => now(),
                    ]);
                }
            }
        });

        return redirect()
            ->route('students.show', $student)
            ->withToast([
                'type' => 'success',
                'message' => 'Student updated successfully!',
            ]);
    }

    public function destroy(Student $student)
    {
        DB::transaction(function () use ($student) {
            $student->user->delete(); // Soft delete user
            $student->delete(); // Soft delete student
        });

        return redirect()
            ->route('students.index')
            ->withToast([
                'type' => 'success',
                'message' => 'Student deleted successfully!',
            ]);
    }

    public function restore($id)
    {
        $student = Student::onlyTrashed()->findOrFail($id);
        
        DB::transaction(function () use ($student) {
            $student->restore();
            // Restore user if it was deleted same time? 
             // Ideally we should restore user too but it might be complex if user was deleted separately.
             // For now assume loose coupling or manual restore of user if needed, OR restore user here too.
             if($student->user()->onlyTrashed()->exists()) {
                 $student->user()->onlyTrashed()->first()->restore();
             }
        });

        return redirect()
            ->route('students.index')
            ->withToast([
                'type' => 'success',
                'message' => 'Student restored successfully!',
            ]);
    }

    public function showImport()
    {
        return view('admin.students.import');
    }

    public function showCourses(Student $student)
    {
        $student->load(['user.college', 'degree']);
        
        // Get assigned courses from assigned_courses table
        $assignedCourses = AssignedCourse::where('student_id', $student->user_id)
            ->with(['course', 'assignedBy'])
            ->get();
        
        return view('admin.students.courses', compact('student', 'assignedCourses'));
    }

    public function importBulk(\App\Http\Requests\Admin\Student\BulkImportStudentRequest $request)
    {
        $file = $request->file('csv_file');
        $successCount = 0;
        $errors = [];
        $studentsData = [];

        try {
            if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
                $header = fgetcsv($handle);
                $rowNumber = 1;

                while (($row = fgetcsv($handle)) !== false) {
                    $rowNumber++;
                    if (empty(array_filter($row))) continue;

                    $data = array_combine($header, $row);

                    if (empty($data['first_name']) || empty($data['last_name']) || empty($data['email']) || empty($data['college_id'])) {
                        $errors[] = "Row {$rowNumber}: Missing required fields";
                        continue;
                    }

                    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                        $errors[] = "Row {$rowNumber}: Invalid email - {$data['email']}";
                        continue;
                    }

                    if (User::where('email', $data['email'])->exists()) {
                        $errors[] = "Row {$rowNumber}: Email exists - {$data['email']}";
                        continue;
                    }

                    $studentsData[] = $data;
                }
                fclose($handle);
            }

            if (!empty($studentsData)) {
                DB::transaction(function () use ($studentsData, &$successCount) {
                    foreach ($studentsData as $data) {
                        $password = \Illuminate\Support\Str::random(10);

                        $user = User::create([
                            'first_name' => $data['first_name'],
                            'last_name' => $data['last_name'],
                            'email' => $data['email'],
                            'password' => bcrypt($password),
                            'phone_number' => $data['phone_number'] ?? null,
                            'college_id' => $data['college_id'],
                            'role' => User::ROLE_STUDENT,
                            'active_status' => isset($data['active_status']) ? (bool)$data['active_status'] : true,
                            'created_by' => auth()->id(),
                        ]);

                        $student = Student::create([
                            'user_id' => $user->id,
                            'degree_id' => !empty($data['degree_id']) ? $data['degree_id'] : null,
                            'specialization' => $data['specialization'] ?? null,
                            'year_of_study' => !empty($data['year_of_study']) ? $data['year_of_study'] : null,
                            'enrollment_no' => 'ENRO_' . $data['college_id'] . '_' . $user->id,
                            'date_of_birth' => !empty($data['date_of_birth']) ? $data['date_of_birth'] : null,
                            'active_status' => isset($data['active_status']) ? (bool)$data['active_status'] : true,
                            'created_by' => auth()->id(),
                        ]);

                        Mail::send(new StudentRegistrationMail($student, $data['email'], $password));
                        $successCount++;
                    }
                });
            }

            $message = "Successfully imported {$successCount} student(s).";
            if (!empty($errors)) $message .= " " . count($errors) . " error(s) occurred.";

            return redirect()->route('students.import.form')
                ->with('success', $message)
                ->with('errors_list', $errors)
                ->with('success_count', $successCount);

        } catch (\Exception $e) {
            return redirect()->route('students.import.form')
                ->withToast(['type' => 'error', 'message' => 'Import failed: ' . $e->getMessage()]);
        }
    }
}
