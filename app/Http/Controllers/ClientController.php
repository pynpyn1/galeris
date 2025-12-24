<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use function Ramsey\Uuid\v1;

class ClientController extends Controller
{
    public function login()
    {
        return view('auth.client.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('client.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function registerview()
    {
        return view('auth.client.register');
    }


    public function register(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('auth.client.register');
        }

        $request->validate([
            'profile_photo_path' => 'nullable|image|max:2048',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'name_engaged' => 'required|string|max:255',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'name_engaged' => $request->name_engaged,
            'role_group_id' => 2,
        ]);

        auth()->login($user);

        return redirect()->route('client.dashboard');
    }
}
