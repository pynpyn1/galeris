<?php

namespace App\Http\Controllers;

use App\Models\RoleGroupModel;
use App\Models\RolePermissionModel;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roleGroups = RoleGroupModel::with('permissions')->get();
        $permissions = RolePermissionModel::all();


        return view('dashboard.role.read', compact('roleGroups', 'permissions'));
    }

    public function managementIndex()
    {
        $roleGroups = RoleGroupModel::all();
        $permissions = RolePermissionModel::all();

        return view('dashboard.role.management', compact('roleGroups', 'permissions'));
    }

    public function assignmentIndex()
    {

        $roleGroups = RoleGroupModel::with('permissions')->where('id', '!=', 2)->get();
        $permissions = RolePermissionModel::all();

        return view('dashboard.role.assignment', compact('roleGroups', 'permissions'));
    }

    public function group(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:role_group,name']);

        RoleGroupModel::create([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Role Group berhasil ditambahkan!');
    }

    public function destroyGroup($id)
    {
        $roleGroup = RoleGroupModel::find($id);

        if (!$roleGroup) {
            return back()->with('error', 'Role Group tidak ditemukan.');
        }

        $groupName = $roleGroup->name;
        $roleGroup->delete();

        return back()->with('success', "Role Group {$groupName} berhasil dihapus.");
    }

    public function permission(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:role_permission,name']);

        RolePermissionModel::create([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Permission berhasil ditambahkan!');
    }

    public function destroyPermission($id)
    {
        $permission = RolePermissionModel::find($id);

        if (!$permission) {
            return back()->with('error', 'Permission tidak ditemukan.');
        }


        $permissionName = $permission->name;
        $permission->delete();

        return back()->with('success', "Permission {$permissionName} berhasil dihapus.");
    }

    public function assign(Request $request)
    {

        $request->validate([
            'assignments' => 'nullable|array',
        ]);

        $assignments = $request->assignments;

        $allRoleGroups = RoleGroupModel::whereIn('id', array_keys($assignments ?? []))->get();

        $syncedGroups = [];

        foreach ($allRoleGroups as $roleGroup) {
            $groupId = $roleGroup->id;
            $permissionsToSync = array_keys($assignments[$groupId] ?? []);
            $roleGroup->permissions()->sync($permissionsToSync);
            $syncedGroups[] = $roleGroup->name;
        }

        if (empty($syncedGroups)) {
            return back()->with('success', 'Tidak ada perubahan penugasan yang dikirimkan.');
        }


        return back()->with('success', "Permissions berhasil diperbarui!");
    }
}
