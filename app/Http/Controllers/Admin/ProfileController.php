<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the edit settings form view canvas.
     */
    public function edit()
    {
        return view('admin.settings.edit', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Update the authenticated administrative data parameters.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // 1. Rigorous Data Verification Mapping
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:20048'], // 2MB Max Size limit
            'current_password' => ['nullable', 'required_with:new_password', 'string'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // 2. Handle Binary Profile Picture Upload Streams
        if ($request->hasFile('image')) {
            // Delete old asset path securely if it exists
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            
            // Store and override relative location map
            $validated['image'] = $request->file('image')->store('profiles', 'public');
        }

        // 3. Handle Password Change
        if ($request->filled('new_password')) {
            // Verify current password
            if (!password_verify($request->current_password, $user->password)) {
                return redirect()->route('admin.settings.edit')
                    ->withErrors(['current_password' => 'The current password is incorrect.'])
                    ->withInput();
            }
            
            // Update to new password
            $user->password = bcrypt($request->new_password);
        }

        // 4. Update user profile fields
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? $user->phone;
        
        if (isset($validated['image'])) {
            $user->image = $validated['image'];
        }

        // 5. Persist Database Record Structure Matrix
        $user->save();

        return redirect()->route('admin.settings.edit')->with('success', 'Your administrator credentials have been updated successfully!');
    }
}