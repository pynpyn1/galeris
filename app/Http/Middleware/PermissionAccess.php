<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionAccess
{
    public function handle(Request $request, Closure $next, string $permissionName)
    {
        if (!Auth::check()) {
            return redirect()->route('client.login');
        }

        $user = Auth::user();

        if (!$user->roleGroup) {
            return redirect('/')->with('error', 'Akses ditolak: Peran pengguna tidak terdefinisi.');
        }

        if (!$user->hasPermissionTo($permissionName)) {
            return redirect('/')->with('error', 'Akses ditolak. Anda tidak memiliki izin.');
        }

        return $next($request);
    }
}
