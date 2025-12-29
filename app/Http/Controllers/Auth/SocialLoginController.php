<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirectToProvider($provider)
    {
        if ($provider === 'google') {
            return Socialite::driver('google')->stateless()->redirect();
        }

        return Socialite::driver($provider)
            ->scopes($provider === 'discord' ? ['identify', 'email'] : ['email'])
            ->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $socialUser = $provider === 'google'
            ? Socialite::driver('google')->stateless()->user()
            : Socialite::driver($provider)->user();

        $user = User::where($provider.'_id', $socialUser->id)->first();

        if (!$user && $socialUser->email) {
            $user = User::where('email', $socialUser->email)->first();

            if ($user) {
                $user->update([
                    $provider.'_id' => $socialUser->id
                ]);
            }
        }

        if (!$user) {
            $photoPath = null;
            if ($socialUser->avatar) {
                $contents = file_get_contents($socialUser->avatar);
                $filename = $provider.'_'.Str::random(20).'.png';
                Storage::disk('public')->put('profile_photos/'.$filename, $contents);
                $photoPath = 'profile_photos/'.$filename;
            }

            $user = User::create([
                'name' => $socialUser->name,
                'email' => $socialUser->email ?? $socialUser->id.'@'.$provider.'.local',
                $provider.'_id' => $socialUser->id,
                'password' => bcrypt(Str::random(16)),
                'profile_photo_path' => $photoPath,
                'role_group_id' => 2,
            ]);
        } else {
            if (!$user->profile_photo_path && $socialUser->avatar) {
                $photoPath = file_get_contents($socialUser->avatar);
                $filename = $provider.'_'.Str::random(20).'.png';
                Storage::disk('public')->put('profile_photos/'.$filename, $photoPath);
                $user->update(['profile_photo_path' => 'profile_photos/'.$filename]);
            }

            if (!$user->{$provider.'_id'}) {
                $user->update([$provider.'_id' => $socialUser->id]);
            }
        }

        Auth::login($user, true);

        if (empty($user->phone)) {
            return redirect()->route('auth.phone');
        }

        return $user->hasPermissionTo('dashboard')
            ? redirect()->intended('/dashboard')
            : redirect()->intended('/home');
    }
}
