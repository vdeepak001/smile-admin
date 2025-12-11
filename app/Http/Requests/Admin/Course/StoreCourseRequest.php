<?php

namespace App\Http\Requests\Admin\Course;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
        return [
            'course_name' => 'required|string|max:255|unique:courses,course_name',
            'course_code' => 'required|string|max:50|unique:courses,course_code',
            'description' => 'nullable|string|max:5000',
            'course_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'test_questions' => 'required|integer|min:0|max:1000',
            'percent_require' => 'required|integer|min:0|max:100',


            'active_status' => 'boolean',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'course_name.required' => 'Course name is required.',
            'course_name.unique' => 'This course name already exists.',
            'course_name.max' => 'Course name must not exceed 255 characters.',
            'course_code.required' => 'Course code is required.',
            'course_code.unique' => 'This course code already exists.',
            'course_code.max' => 'Course code must not exceed 50 characters.',
            'description.max' => 'Description must not exceed 5000 characters.',
            'course_pic.image' => 'Course picture must be an image file.',
            'course_pic.mimes' => 'Course picture must be a jpeg, png, jpg, or gif file.',
            'course_pic.max' => 'Course picture must not exceed 2MB.',
            'test_questions.required' => 'Test questions field is required.',
            'test_questions.integer' => 'Test questions must be a whole number.',
            'test_questions.min' => 'Test questions must be at least 0.',
            'test_questions.max' => 'Test questions must not exceed 1000.',
            'percent_require.required' => 'Percent required field is required.',
            'percent_require.integer' => 'Percent required must be a whole number.',
            'percent_require.min' => 'Percent required must be at least 0.',
            'percent_require.max' => 'Percent required must not exceed 100.',

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function attributes(): array
    {
        return [
            'course_name' => 'course name',
            'course_code' => 'course code',
            'description' => 'description',
            'course_pic' => 'course picture',
            'test_questions' => 'test questions',
            'percent_require' => 'percent required',


            'active_status' => 'active status',
        ];
    }
}

