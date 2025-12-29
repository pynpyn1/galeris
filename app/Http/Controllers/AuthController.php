<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }

    public function store (Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->filled('remember');
        if (auth()->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            if (Auth::check() && (Auth::user()->hasPermissionTo('dashboard'))) {
                return redirect()->intended('/dashboard');
            }else {
                return redirect()->intended('/home');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }


    public function logout(Request $request)
    {
        $user = Auth::user();


        if ($user && !empty($user->wa_session_id)) {
            try {
                Http::timeout(5)->post(
                    config('app.whatsapp_api_url') . '/logout',
                    [
                        'wa_session_id' => $user->wa_session_id,
                    ]
                );
            } catch (\Throwable $e) {
                Log::warning('WA logout skipped / failed: ' . $e->getMessage());
            }
        }


        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }


   public function phone()
    {
        $user = auth()->user();

        abort_if(!empty($user->phone), 403);

        return view('auth.phone', compact('user'));
    }

    public function phoneUpdate(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:9|max:15',
        ]);

        auth()->user()->update([
            'phone' => $request->phone,
        ]);

        return redirect('/home');
    }


}
