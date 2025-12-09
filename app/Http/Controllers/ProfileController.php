<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');

            // Validate the file
            if ($file->isValid()) {
                // Delete old avatar if exists
                if ($user->avatar && Storage::disk('public')->exists('avatars/' . $user->avatar)) {
                    Storage::disk('public')->delete('avatars/' . $user->avatar);
                }

                $avatarName = time() . '_' . $user->id . '.' . $file->extension();

                // Store the file on the public disk so it is web-accessible
                $path = $file->storeAs('avatars', $avatarName, 'public');

                if ($path) {
                    $validated['avatar'] = $avatarName;
                    Log::info('Avatar uploaded successfully: ' . $avatarName);
                } else {
                    Log::error('Failed to store avatar file');
                    return Redirect::route('profile.edit')->withErrors(['avatar' => 'Failed to upload avatar.']);
                }
            } else {
                Log::error('Invalid avatar file uploaded');
                return Redirect::route('profile.edit')->withErrors(['avatar' => 'Invalid file.']);
            }
        }

        // Remove avatar from validated data if no file uploaded
        if (!$request->hasFile('avatar')) {
            unset($validated['avatar']);
        }

        // Filter out rights fields if user is not admin
        if (!$user->canUpdateRights()) {
            unset($validated['college_rights'], $validated['course_rights'], $validated['students_rights'], $validated['active_status']);
        }

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')
            ->with('status', 'profile-updated')
            ->with('toast', [
                'type' => 'success',
                'message' => 'Profile updated successfully.',
            ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
