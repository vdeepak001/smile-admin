<?php

namespace App\Http\Requests\Admin\CourseTopic;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseTopicRequest extends FormRequest
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
            'course_id' => 'required|exists:courses,course_id',
            'topic_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'topic_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,txt,zip|max:10240',
            'active_status' => 'boolean',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'course_id.required' => 'Course is required.',
            'course_id.exists' => 'Selected course does not exist.',
            'topic_name.required' => 'Topic name is required.',
            'topic_name.max' => 'Topic name must not exceed 255 characters.',
            'topic_pic.image' => 'Topic picture must be an image file.',
            'topic_pic.mimes' => 'Topic picture must be a jpeg, png, jpg, or gif file.',
            'topic_pic.max' => 'Topic picture must not exceed 2MB.',
            'attachment.file' => 'Attachment must be a file.',
            'attachment.mimes' => 'Attachment must be a pdf, doc, docx, ppt, pptx, txt, or zip file.',
            'attachment.max' => 'Attachment must not exceed 10MB.',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function attributes(): array
    {
        return [
            'course_id' => 'course',
            'topic_name' => 'topic name',
            'description' => 'description',
            'topic_pic' => 'topic picture',
            'attachment' => 'attachment',
            'active_status' => 'active status',
        ];
    }
}
