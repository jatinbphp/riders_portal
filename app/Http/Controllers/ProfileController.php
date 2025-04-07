<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\DocumentUpload;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $document = DocumentUpload::where('user_id', $request->user()->id)->first();

        return view('profile.edit', [
            'user' => $request->user(),
            'document' => $document,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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

    public function saveDocuments(Request $request)
    {
        $request->validate([
            'speed' => 'required|integer|min:0|max:100',
            'strength' => 'required|integer|min:0|max:100',
            'agility' => 'required|integer|min:0|max:100',
            'endurance' => 'required|integer|min:0|max:100',
            'flexibility' => 'required|integer|min:0|max:100', 
            'document_path' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
        ]);

        $user = auth()->user();

        $existing = DocumentUpload::where('user_id', $user->id)->first();

        $data = $request->only(['speed', 'strength', 'agility', 'endurance', 'flexibility']);

        if ($request->hasFile('document_path')) {
            $data['document_path'] = $request->file('document_path')->store('documents', 'public');

            if ($existing && $existing->document_path) {
                Storage::disk('public')->delete($existing->document_path);
            }
        }

        if ($existing) {
            $existing->update($data);
        } else {
            $data['user_id'] = $user->id;
            DocumentUpload::create($data);
        }
 
        return back()->with('success', 'Profile and documents updated successfully!');
    }
}
