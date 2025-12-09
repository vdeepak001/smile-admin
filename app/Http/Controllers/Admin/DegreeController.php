<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Degree;
use App\Http\Requests\Admin\Degree\StoreDegreeRequest;
use App\Http\Requests\Admin\Degree\UpdateDegreeRequest;
use Illuminate\Http\Request;

class DegreeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.degrees.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.degrees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDegreeRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = auth()->id();
        // active_status default is handling in database or we can force it here if needed, 
        // but request validation says nullable boolean, so we should check.
        // If checkbox is unchecked, it might not send anything, so we handle that.
        $validated['active_status'] = $request->has('active_status');

        Degree::create($validated);

        return redirect()
            ->route('degrees.index')
            ->withToast([
                'type' => 'success',
                'message' => 'Degree created successfully!',
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Degree $degree)
    {
        return view('admin.degrees.edit', compact('degree'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDegreeRequest $request, Degree $degree)
    {
        $validated = $request->validated();
        $validated['updated_by'] = auth()->id();
        $validated['active_status'] = $request->has('active_status');

        $degree->update($validated);

        return redirect()
            ->route('degrees.index')
            ->withToast([
                'type' => 'success',
                'message' => 'Degree updated successfully!',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Degree $degree)
    {
        $degree->delete();

        return redirect()
            ->route('degrees.index')
            ->withToast([
                'type' => 'success',
                'message' => 'Degree deleted successfully!',
            ]);
    }
}
