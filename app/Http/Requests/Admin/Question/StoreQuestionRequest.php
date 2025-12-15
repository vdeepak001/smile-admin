<?php

namespace App\Http\Requests\Admin\Question;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
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
            'topic_id' => 'required|exists:course_topics,topic_id',
            'question_type' => 'required|string|in:multiple_choice,true_false,short_answer',
            'question_text' => 'required|string',
            'level' => 'required|integer|min:1|max:5',
            'pic_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pic_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pic_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'choice_1' => 'nullable|string|max:500',
            'choice_2' => 'nullable|string|max:500',
            'choice_3' => 'nullable|string|max:500',
            'choice_4' => 'nullable|string|max:500',
            'choice_pic_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'choice_pic_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'choice_pic_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'choice_pic_4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'right_answer' => 'nullable|string|max:500',
            'reasoning' => 'nullable|string',
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
            'topic_id.required' => 'Topic is required.',
            'topic_id.exists' => 'Selected topic does not exist.',
            'question_type.required' => 'Question type is required.',
            'question_type.in' => 'Question type must be multiple choice, true/false, or short answer.',
            'question_text.required' => 'Question text is required.',
            'level.required' => 'Difficulty level is required.',
            'level.min' => 'Difficulty level must be at least 1.',
            'level.max' => 'Difficulty level must not exceed 5.',
            'pic_1.image' => 'Picture 1 must be an image file.',
            'pic_1.mimes' => 'Picture 1 must be a jpeg, png, jpg, or gif file.',
            'pic_1.max' => 'Picture 1 must not exceed 2MB.',
            'pic_2.image' => 'Picture 2 must be an image file.',
            'pic_2.max' => 'Picture 2 must not exceed 2MB.',
            'pic_3.image' => 'Picture 3 must be an image file.',
            'pic_3.max' => 'Picture 3 must not exceed 2MB.',
            'choice_pic_1.image' => 'Choice picture 1 must be an image file.',
            'choice_pic_1.max' => 'Choice picture 1 must not exceed 2MB.',
            'choice_pic_2.image' => 'Choice picture 2 must be an image file.',
            'choice_pic_2.max' => 'Choice picture 2 must not exceed 2MB.',
            'choice_pic_3.image' => 'Choice picture 3 must be an image file.',
            'choice_pic_3.max' => 'Choice picture 3 must not exceed 2MB.',
            'choice_pic_4.image' => 'Choice picture 4 must be an image file.',
            'choice_pic_4.max' => 'Choice picture 4 must not exceed 2MB.',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function attributes(): array
    {
        return [
            'course_id' => 'course',
            'topic_id' => 'topic',
            'question_type' => 'question type',
            'question_text' => 'question text',
            'level' => 'difficulty level',
            'pic_1' => 'picture 1',
            'pic_2' => 'picture 2',
            'pic_3' => 'picture 3',
            'choice_1' => 'choice 1',
            'choice_2' => 'choice 2',
            'choice_3' => 'choice 3',
            'choice_4' => 'choice 4',
            'choice_pic_1' => 'choice picture 1',
            'choice_pic_2' => 'choice picture 2',
            'choice_pic_3' => 'choice picture 3',
            'choice_pic_4' => 'choice picture 4',
            'right_answer' => 'right answer',
            'reasoning' => 'reasoning',
            'active_status' => 'active status',
        ];
    }
}
