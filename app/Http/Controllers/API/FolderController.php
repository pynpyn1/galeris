<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FolderModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FolderController extends Controller
{
    public function data(Request $request)
    {
        if ($request->ajax()) {

            $query = FolderModel::withTrashed();

            return DataTables::of($query)->addIndexColumn()
                ->addColumn('status', function ($folder) {
                    if ($folder->deleted_at) {
                        $class = 'bg-warning';
                        $text = 'Deleted';
                    } else {
                        if ($folder->visibility === 'public') {
                            $class = 'bg-light-success';
                            $text = 'Public';
                        } else {
                            $class = 'bg-secondary';
                            $text = 'Private';
                        }
                    }
                    return "<span class=\"badge {$class}\">{$text}</span>";
                })
                   ->addColumn('action', function ($folder) {
                    $deleteUrl = route('manage.folder.destroy', $folder->id);

                    $editUrl = route('manage.folder.edit', $folder->id);

                    $editButton = '
                        <a href="' . $editUrl . '"
                            class="btn btn-info btn-sm me-2">
                            Edit
                        </a>
                    ';

                    $actions = $editButton;

                    if ($folder->deleted_at) {
                        $actions .= '<button type="button" class="btn btn-danger btn-sm" disabled>Deleted</button>';
                    } else {
                        $deleteForm = '
                            <form id="delete-form-' . $folder->id . '" action="' . $deleteUrl . '" method="POST" class="d-inline">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="button" class="btn btn-danger btn-sm delete-folder-btn" data-id="' . $folder->id . '">Delete</button>
                            </form>
                        ';
                        $actions .= $deleteForm;
                    }


                    return $actions;
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }

        return response()->json(['message' => 'Invalid request'], 400);
    }
}
