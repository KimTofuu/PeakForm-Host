<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'nullable|integer|min:0',
            'gender' => 'nullable|string|max:50',
            'weight' => 'nullable|numeric|min:20|max:300',
        ]);

        // Split name into first and last (optional, adjust as needed)
        $nameParts = preg_split('/\s+/', trim($validated['name']));
        $fname = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 0, -1)) : $validated['name'];
        $lname = count($nameParts) > 1 ? end($nameParts) : '';

        $profile = Profile::firstOrNew(['user_id' => $user->id]);
        $profile->Fname = $fname;
        $profile->Lname = $lname;
        $profile->age = $validated['age'];
        $profile->gender = $validated['gender'];
        $profile->weight = $validated['weight'];
        $profile->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function show()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();

        return view('profile_tab', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    public function updateFromMacros(Request $request)
    {
        $user = Auth::user();

        // This is needed for JSON requests!
        if ($request->isJson()) {
            $request->merge($request->json()->all());
        }

        $validated = $request->validate([
            'age' => 'required|integer|min:13|max:80',
            'weight' => 'required|numeric|min:30|max:200',
            'gender' => 'required|in:male,female',
        ]);

        $profile = \App\Models\Profile::firstOrNew(['user_id' => $user->id]);
        if (!$profile->exists) {
            $profile->Fname = '';
            $profile->Lname = '';
        }
        $profile->age = $validated['age'];
        $profile->weight = $validated['weight'];
        $profile->gender = $validated['gender'];
        $profile->user_id = $user->id;
        $profile->save();

        return response()->json(['success' => true]);
    }
}
