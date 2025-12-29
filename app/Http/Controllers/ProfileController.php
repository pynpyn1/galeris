<?php

namespace App\Http\Controllers;

use App\Models\PurchaseModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $hasActivePackage = PurchaseModel::with('package')
            ->where('user_id', Auth::id())
            ->active()
            ->first();

        return view('dashboard.profile.index', ['user' => $user, 'hasActivePackage' => $hasActivePackage]);
    }

    public function update(Request $request, User $profile)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'profile_photo_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required' => 'Nama Diperlukan',

        ]);

        // Upload Foto
        if ($request->hasFile('profile_photo_path')) {
            $path = $request->file('profile_photo_path')->store('profile_photos', 'public');
            $profile->profile_photo_path = $path;
        }

        // Update data
        $profile->update($request->only('name', 'email'));

        $profile->save();

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    public function password(Request $request, User $profile)
    {
        $request->validate([
            'new_password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $profile->password = Hash::make($request->new_password);
        $profile->save();

        return back()->with('success', 'Password berhasil diubah');
    }
}
