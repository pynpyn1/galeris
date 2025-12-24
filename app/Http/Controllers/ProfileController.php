<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    public function index(User $profile)
    {
        return view('dashboard.profile.index', ['user' => $profile]);
    }

    public function update(Request $request, User $profile)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_engaged' => 'nullable|string|max:255',
            'email' => 'required|email',
            'profile_photo_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload Foto
        if ($request->hasFile('profile_photo_path')) {
            $path = $request->file('profile_photo_path')->store('profile', 'public');
            $profile->profile_photo_path = $path;
        }

        // Update data
        $profile->update($request->only('name', 'name_engaged', 'email'));

        $profile->save();

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    public function password(Request $request, User $profile)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if (!Hash::check($request->current_password, $profile->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah!']);
        }

        $profile->password = Hash::make($request->new_password);
        $profile->save();

        return back()->with('success', 'Password berhasil diubah');
    }
}
