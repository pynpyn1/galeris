<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PhotoModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PhotoController extends Controller
{
    public function data(Request $request)
    {
        if ($request->ajax()) {

            $query = \App\Models\FolderModel::get();

            return DataTables::of($query)->addIndexColumn()->addColumn('folder_name', function ($folder) {
                    return $folder->name;
                })->addColumn('file_path', function ($folder) {
                    if ($folder->photos->isEmpty()) {
                        return "<span class='text-muted'>Tidak ada foto</span>";
                    }

                    $allPhotos = [];
                    foreach ($folder->photos as $p) {
                        $allPhotos[] = asset('storage/' . $p->file_path);
                    }

                    $photoJson = htmlspecialchars(json_encode($allPhotos), ENT_QUOTES, 'UTF-8');

                    $html = "<div class='photo-stack' data-photos=\"{$photoJson}\" style='position:relative; width:120px; height:50px; cursor:pointer;'>";

                    $index = 0;
                    foreach ($folder->photos as $photo) {
                        $url = asset('storage/' . $photo->file_path);
                        $offset = $index * 12;

                        $html .= "
                            <img src='{$url}'
                                class='thumb-photo'
                                style='
                                    position:absolute;
                                    left:{$offset}px;
                                    top:0;
                                    width:50px;
                                    height:50px;
                                    object-fit:cover;
                                    border-radius:6px;
                                    border:1px solid #ddd;
                                    box-shadow:0 2px 5px rgba(0,0,0,0.2);
                                '
                            >
                        ";
                        $index++;
                    }

                    $html .= "</div>";

                    return $html;
                })->addColumn('status', function ($folder) {

                    $deleted = $folder->photos->whereNotNull('deleted_at')->count();
                    $active = $folder->photos->whereNull('deleted_at')->count();

                    if ($active > 0 && $deleted > 0) {
                        return '<span class="badge bg-warning">Mixed</span>';
                    }

                    if ($active > 0) {
                        return '<span class="badge bg-success">Active</span>';
                    }

                    if ($deleted > 0) {
                        return '<span class="badge bg-danger">Deleted</span>';
                    }

                    return '<span class="badge bg-secondary">Empty</span>';
                })->addColumn('action', function ($folder) {
                    $editUrl = route('manage.photo.edit', $folder->id);

                    return '
                        <a href="' . $editUrl . '" class="btn btn-primary btn-sm">
                            Kelola Foto
                        </a>
                    ';
                })->rawColumns(['file_path', 'status', 'action'])->make(true);
        }

        return response()->json(['message' => 'Invalid request'], 400);
    }

}
