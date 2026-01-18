<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function data(Request $request)
    {
        if ($request->ajax()) {

            $query = User::withTrashed()->with('roleGroup')->get();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('role_group', function ($user) {
                    return $user->roleGroup->name ?? '-';
                })
                ->addColumn('status', function ($user) {
                    if ($user->deleted_at) {
                        return '<span class="badge bg-warning">Deleted</span>';
                    }
                    return '<span class="badge bg-success">Active</span>';
                })
                ->addColumn('action', function ($user) {
                    $editUrl = route('manage.users.edit', $user->id);
                    $deleteUrl = route('manage.users.destroy', $user->id);

                    $editBtn = '<a href="'.$editUrl.'" class="btn btn-info btn-sm me-2">Edit</a>';

                    if ($user->deleted_at) {
                        return $editBtn . '<button class="btn btn-danger btn-sm" disabled>Deleted</button>';
                    }

                    $deleteForm = '
                        <form id="delete-form-'.$user->id.'" action="'.$deleteUrl.'" method="POST" class="d-inline">
                            '.csrf_field().method_field('DELETE').'
                            <button type="button" class="btn btn-danger btn-sm delete-user-btn" data-id="'.$user->id.'">Delete</button>
                        </form>
                    ';

                    return $editBtn . $deleteForm;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return response()->json(['message' => 'Invalid request'], 400);
    }

}
