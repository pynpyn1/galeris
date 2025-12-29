<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;


class DiscordController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('discord')
            ->scopes(['identify', 'email'])
            ->redirect();
    }

    public function callback()
    {
        $discordUser = Socialite::driver('discord')->user();

        $user = User::where('discord_id', $discordUser->id)->first();

        $photoPath = null;

        if ($discordUser->avatar) {
            $contents = file_get_contents($discordUser->avatar);
            $filename = 'discord_' . Str::random(20) . '.png';

            Storage::disk('public')->put('profile-photos/' . $filename, $contents);
            $photoPath = 'profile-photos/' . $filename;
        }

        if (!$user) {
            $user = User::create([
                'discord_id' => $discordUser->id,
                'name' => $discordUser->name,
                'email' => $discordUser->email ?? $discordUser->id . '@discord.local',
                'password' => bcrypt(Str::random(16)),
                'profile_photo_path' => $photoPath,
                'role_group_id' => 2,
            ]);
        } else {
            if ($photoPath) {
                $user->update([
                    'profile_photo_path' => $photoPath,
                ]);
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
