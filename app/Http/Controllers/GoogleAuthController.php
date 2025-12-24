<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name'      => $googleUser->getName(),
                'email'     => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'profile_photo_path' => $googleUser->getAvatar(),
                'password'  => bcrypt(Str::random(20)),
                'role_group_id' => 2,
            ]);
        } else {
            $update = [];

            if (!$user->google_id) {
                $update['google_id'] = $googleUser->getId();
            }

            if (!$user->profile_photo_path) {
                $update['profile_photo_path'] = $googleUser->getAvatar();
            }

            if (!empty($update)) {
                $user->update($update);
            }
        }

        Auth::login($user, true);
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
