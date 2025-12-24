<?php

namespace App\Http\Controllers;

use App\Models\RoleGroupModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        return view('dashboard.user.read');
    }

    public function create()
    {
        $roles = RoleGroupModel::all();
        return view('dashboard.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            "name"           => "required|string|max:255",
            "email"          => "required|email|unique:users,email",
            "password"       => "required|min:6",
            'phone'          => "required",
            "role_group_id"  => "required|exists:role_group,id",
        ]);

        User::create([
            "name"           => $request->name,
            "email"          => $request->email,
            "password"       => Hash::make($request->password),
            "phone"          => "62" .$request->phone,
            "role_group_id"  => $request->role_group_id,
        ]);

        return redirect()->route('manage.users.index')
            ->with('success', 'Berhasil membuat user baru');
    }

    public function edit($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $roles = RoleGroupModel::all();
        return view('dashboard.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            "name"           => "required|string|max:255",
            "email"          => "required|email|unique:users,email," . $user->id,
            "password"       => "nullable|min:6",
            "role_group_id"  => "required|exists:role_group,id",
        ]);

        $user->name          = $request->name;
        $user->email         = $request->email;
        $user->role_group_id = $request->role_group_id;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('manage.users.index')
            ->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('manage.users.index')
            ->with('success', 'User deleted successfully');
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('manage.users.index')->with('success', 'User berhasil direstore.');
    }


}
