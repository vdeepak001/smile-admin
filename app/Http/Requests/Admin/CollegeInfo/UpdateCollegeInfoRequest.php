<?php

namespace App\Http\Requests\Admin\CollegeInfo;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCollegeInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $collegeId = $this->route('college_info')?->college_id;
        $userId = $this->route('college_info')?->user_id;

        return [
            'college_name' => 'required|string|max:255|unique:college_info,college_name,' . $collegeId . ',college_id',
            'email' => 'required|email|max:255|unique:users,email,' . $userId . ',id',
            // 'password' => 'nullable|string|min:8|confirmed', // Removed from form
            'contact_person' => 'required|string|max:255',
            'course_ids' => 'required|array',
            'course_ids.*' => 'exists:courses,course_id',
            'max_students' => 'required|integer|min:1|max:10000',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'active_status' => 'boolean',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'college_name.required' => 'College name is required.',
            'college_name.unique' => 'This college name already exists.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already in use.',
            // 'password.min' => 'Password must be at least 8 characters long.',
            // 'password.confirmed' => 'Password confirmation does not match.',
            'contact_person.required' => 'Contact person name is required.',
            'course_ids.required' => 'Please select at least one course.',
            'course_ids.array' => 'Courses selection must be valid.',
            'course_ids.*.exists' => 'One or more selected courses do not exist.',
            'max_students.required' => 'Maximum students field is required.',
            'max_students.integer' => 'Maximum students must be a whole number.',
            'max_students.min' => 'Maximum students must be at least 1.',
            'valid_from.required' => 'Valid from date is required.',
            'valid_until.required' => 'Valid until date is required.',
            'valid_until.after' => 'Valid until date must be after the valid from date.',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function attributes(): array
    {
        return [
            'college_name' => 'college name',
            'email' => 'email address',
            // 'password' => 'password',
            'contact_person' => 'contact person',
            'course_id' => 'course',
            'max_students' => 'maximum students',
            'valid_from' => 'valid from date',
            'valid_until' => 'valid until date',
            'active_status' => 'active status',
        ];
    }
}
