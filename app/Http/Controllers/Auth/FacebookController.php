<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FacebookController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')
            ->scopes(['email'])
            ->redirect();
    }

    public function callback()
    {
        $fbUser = Socialite::driver('facebook')->user();

        $user = User::where('facebook_id', $fbUser->id)->first();

        // Download avatar Facebook
        $photoPath = null;
        if ($fbUser->avatar) {
            $contents = file_get_contents($fbUser->avatar);
            $filename = 'facebook_' . Str::random(20) . '.jpg';
            Storage::disk('public')->put('profile-photos/' . $filename, $contents);
            $photoPath = 'profile-photos/' . $filename;
        }

        if (!$user) {
            $user = User::create([
                'facebook_id' => $fbUser->id,
                'name' => $fbUser->name,
                'email' => $fbUser->email ?? $fbUser->id . '@facebook.local',
                'password' => bcrypt(Str::random(16)),
                'profile_photo_path' => $photoPath,
                'role_group_id' => 2,
            ]);
        } else {
            if (!$user->profile_photo_path && $photoPath) {
                $user->update(['profile_photo_path' => $photoPath]);
            }
        }

        Auth::login($user);

        if (empty($user->phone)) {
            return redirect()->route('auth.phone');
        }

        if ($user->hasPermissionTo = 'dashboard') {
            return redirect()->intended('/dashboard');
        }else {
            return redirect()->intended('/home');
        }
    }
}
