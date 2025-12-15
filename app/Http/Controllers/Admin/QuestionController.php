<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Course;
use App\Models\CourseTopic;
use App\Http\Requests\Admin\Question\StoreQuestionRequest;
use App\Http\Requests\Admin\Question\UpdateQuestionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the questions.
     */
    public function index()
    {
        return view('admin.questions.index');
    }

    /**
     * Show the form for creating a new question.
     */
    public function create()
    {
        $courses = Course::where('active_status', true)->orderBy('course_name')->get();
        $topics = CourseTopic::where('active_status', true)->orderBy('topic_name')->get();
        
        return view('admin.questions.create', compact('courses', 'topics'));
    }

    /**
     * Store a newly created question in storage.
     */
    public function store(StoreQuestionRequest $request)
    {
        $validated = $request->validated();

        $validated['inserted_by'] = Auth::id();
        $validated['inserted_on'] = now();

        // Handle question image uploads
        if ($request->hasFile('pic_1')) {
            $validated['pic_1'] = $request->file('pic_1')->store('question-pics', 'public');
        }
        if ($request->hasFile('pic_2')) {
            $validated['pic_2'] = $request->file('pic_2')->store('question-pics', 'public');
        }
        if ($request->hasFile('pic_3')) {
            $validated['pic_3'] = $request->file('pic_3')->store('question-pics', 'public');
        }

        // Handle choice image uploads
        if ($request->hasFile('choice_pic_1')) {
            $validated['choice_pic_1'] = $request->file('choice_pic_1')->store('choice-pics', 'public');
        }
        if ($request->hasFile('choice_pic_2')) {
            $validated['choice_pic_2'] = $request->file('choice_pic_2')->store('choice-pics', 'public');
        }
        if ($request->hasFile('choice_pic_3')) {
            $validated['choice_pic_3'] = $request->file('choice_pic_3')->store('choice-pics', 'public');
        }
        if ($request->hasFile('choice_pic_4')) {
            $validated['choice_pic_4'] = $request->file('choice_pic_4')->store('choice-pics', 'public');
        }

        $question = Question::create($validated);

        return redirect()
            ->route('questions.show', $question)
            ->withToast([
                'type' => 'success',
                'message' => 'Question created successfully!',
            ]);
    }

    /**
     * Display the specified question.
     */
    public function show(Question $question)
    {
        $question->load(['course', 'topic', 'insertedBy', 'updatedBy']);
        return view('admin.questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified question.
     */
    public function edit(Question $question)
    {
        $courses = Course::where('active_status', true)->orderBy('course_name')->get();
        $topics = CourseTopic::where('active_status', true)->orderBy('topic_name')->get();
        
        return view('admin.questions.edit', compact('question', 'courses', 'topics'));
    }

    /**
     * Update the specified question in storage.
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $validated = $request->validated();

        $validated['updated_by'] = Auth::id();
        $validated['updated_on'] = now();

        // Handle question image uploads
        if ($request->hasFile('pic_1')) {
            if ($question->pic_1) {
                Storage::disk('public')->delete($question->pic_1);
            }
            $validated['pic_1'] = $request->file('pic_1')->store('question-pics', 'public');
        } else {
            unset($validated['pic_1']);
        }

        if ($request->hasFile('pic_2')) {
            if ($question->pic_2) {
                Storage::disk('public')->delete($question->pic_2);
            }
            $validated['pic_2'] = $request->file('pic_2')->store('question-pics', 'public');
        } else {
            unset($validated['pic_2']);
        }

        if ($request->hasFile('pic_3')) {
            if ($question->pic_3) {
                Storage::disk('public')->delete($question->pic_3);
            }
            $validated['pic_3'] = $request->file('pic_3')->store('question-pics', 'public');
        } else {
            unset($validated['pic_3']);
        }

        // Handle choice image uploads
        if ($request->hasFile('choice_pic_1')) {
            if ($question->choice_pic_1) {
                Storage::disk('public')->delete($question->choice_pic_1);
            }
            $validated['choice_pic_1'] = $request->file('choice_pic_1')->store('choice-pics', 'public');
        } else {
            unset($validated['choice_pic_1']);
        }

        if ($request->hasFile('choice_pic_2')) {
            if ($question->choice_pic_2) {
                Storage::disk('public')->delete($question->choice_pic_2);
            }
            $validated['choice_pic_2'] = $request->file('choice_pic_2')->store('choice-pics', 'public');
        } else {
            unset($validated['choice_pic_2']);
        }

        if ($request->hasFile('choice_pic_3')) {
            if ($question->choice_pic_3) {
                Storage::disk('public')->delete($question->choice_pic_3);
            }
            $validated['choice_pic_3'] = $request->file('choice_pic_3')->store('choice-pics', 'public');
        } else {
            unset($validated['choice_pic_3']);
        }

        if ($request->hasFile('choice_pic_4')) {
            if ($question->choice_pic_4) {
                Storage::disk('public')->delete($question->choice_pic_4);
            }
            $validated['choice_pic_4'] = $request->file('choice_pic_4')->store('choice-pics', 'public');
        } else {
            unset($validated['choice_pic_4']);
        }

        $question->update($validated);

        return redirect()
            ->route('questions.show', $question)
            ->withToast([
                'type' => 'success',
                'message' => 'Question updated successfully!',
            ]);
    }

    /**
     * Remove the specified question from storage.
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()
            ->route('questions.index')
            ->withToast([
                'type' => 'success',
                'message' => 'Question deleted successfully!',
            ]);
    }

    /**
     * Restore a soft-deleted question.
     */
    public function restore($id)
    {
        $question = Question::onlyTrashed()->findOrFail($id);
        $question->restore();

        return redirect()
            ->route('questions.index')
            ->withToast([
                'type' => 'success',
                'message' => 'Question restored successfully!',
            ]);
    }

    /**
     * Permanently delete a question.
     */
    public function forceDelete($id)
    {
        $question = Question::onlyTrashed()->findOrFail($id);

        // Delete all images if they exist
        $images = [
            $question->pic_1,
            $question->pic_2,
            $question->pic_3,
            $question->choice_pic_1,
            $question->choice_pic_2,
            $question->choice_pic_3,
            $question->choice_pic_4,
        ];

        foreach ($images as $image) {
            if ($image) {
                Storage::disk('public')->delete($image);
            }
        }

        $question->forceDelete();

        return redirect()
            ->route('questions.index')
            ->withToast([
                'type' => 'success',
                'message' => 'Question permanently deleted!',
            ]);
    }
}
