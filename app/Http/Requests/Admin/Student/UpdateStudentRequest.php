<?php

namespace App\Http\Requests\Admin\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $student = $this->route('student'); // Get student from route model binding
        $userId = $student->user_id;

        return [
            // User fields
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($userId)],

            'phone_number' => ['nullable', 'string', 'max:20'],
            'college_id' => ['required', 'exists:college_info,college_id'],
            'degree_id' => ['nullable', 'exists:degrees,id'],
            'specialization' => ['nullable', 'string', 'max:255'],
            'year_of_study' => ['nullable', 'integer', 'min:1', 'max:10'],
            'start_year' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 10)],
            'end_year' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 10), 'gte:start_year'],

            // Student fields
            'roll_number' => ['nullable', 'string', 'max:100'],
            'date_of_birth' => ['nullable', 'date'],

            'active_status' => ['boolean'],

            // Course assignment
            'course_ids' => ['nullable', 'array'],
            'course_ids.*' => ['exists:courses,course_id'],
        ];
    }
}
