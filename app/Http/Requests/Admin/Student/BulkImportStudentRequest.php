<?php

namespace App\Http\Requests\Admin\Student;

use Illuminate\Foundation\Http\FormRequest;

class BulkImportStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:5120'], // 5MB max
            'college_id' => ['required', 'exists:college_info,college_id'],
            'course_ids' => ['required', 'array', 'min:1'],
            'course_ids.*' => ['required', 'exists:courses,course_id'],
        ];
    }

    public function messages(): array
    {
        return [
            'csv_file.required' => 'Please upload a CSV file.',
            'csv_file.mimes' => 'The file must be a CSV file.',
            'csv_file.max' => 'The file size must not exceed 5MB.',
            'college_id.required' => 'Please select a college.',
            'college_id.exists' => 'The selected college is invalid.',
            'course_ids.required' => 'Please select at least one course.',
            'course_ids.min' => 'Please select at least one course.',
            'course_ids.*.exists' => 'One or more selected courses are invalid.',
        ];
    }
}
