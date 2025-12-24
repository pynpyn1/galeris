<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\GalleryModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GalleryController extends Controller
{
    public function data(Request $request)
    {
        if ($request->ajax()) {
            $query = GalleryModel::withTrashed()->get();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('title', function ($gallery) {
                    return $gallery->title;
                })
                ->addColumn('description', function ($gallery) {
                    return $gallery->descrtiption ?? '<span class="text-muted">Tidak ada deskripsi</span>';
                })
                ->addColumn('image', function ($gallery) {
                    $filePath = public_path('storage/' . $gallery->image_path);

                    if (!file_exists($filePath)) {
                        $url = asset('asset/img/404.jpeg');
                    } else {
                        $url = asset('storage/' . $gallery->image_path);
                    }

                    return "<img src='{$url}' class='img-thumbnail preview-photo'
                            style='width:100px;height:60px;object-fit:cover;cursor:pointer;'
                            data-photo='{$url}'>";
                })->addColumn('status', function ($gallery) {
                    if ($gallery->deleted_at) {
                        return '<span class="badge bg-warning">Deleted</span>';
                    }
                    return '<span class="badge bg-success">Active</span>';
                })->addColumn('action', function ($gallery) {
                    $editUrl = route('manage.gallery.edit', $gallery->id);
                    $deleteUrl = route('manage.gallery.destroy', $gallery->id);

                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-primary">Edit</a>
                       <form method="POST" action="' . $deleteUrl . '" class="d-inline" id="delete-form-' . $gallery->id . '">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="button" class="btn btn-sm btn-danger delete-gallery-btn" data-id="' . $gallery->id . '">Hapus</button>
                        </form>
                    ';
                })
                ->rawColumns(['description', 'image', 'action', 'status'])
                ->make(true);
        }

        return response()->json(['message' => 'Invalid request'], 400);
    }

}
