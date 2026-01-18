<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\PhotoModel;
use App\Models\FolderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $folders = FolderModel::where('user_id', $userId)->get();

        return view('dashboard.client.photo.read', compact('folders'));
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {

            $userId = auth()->id();

            $query = \App\Models\FolderModel::where('user_id', $userId)->get();

            return datatables()->of($query)
                ->addIndexColumn()

                ->addColumn('folder_name', fn($folder) => $folder->name)

                ->addColumn('file_path', function ($folder) {
                    if ($folder->photos->isEmpty()) {
                        return "<span class='text-muted'>Tidak ada foto</span>";
                    }

                    $allPhotos = [];
                    foreach ($folder->photos as $p) {
                        $allPhotos[] = asset('storage/' . $p->file_path);
                    }

                    $photoJson = htmlspecialchars(json_encode($allPhotos), ENT_QUOTES, 'UTF-8');

                    $html = "<div class='photo-stack' data-photos=\"{$photoJson}\"
                            style='position:relative; width:120px; height:50px; cursor:pointer;'>";

                    $i = 0;
                    foreach ($folder->photos as $photo) {
                        $url = asset('storage/' . $photo->file_path);
                        $offset = $i * 12;

                        $html .= "
                            <img src='{$url}'
                                style='position:absolute; left:{$offset}px; width:50px; height:50px;
                                object-fit:cover; border-radius:6px; border:1px solid #ddd;'>
                        ";

                        $i++;
                    }

                    $html .= "</div>";

                    return $html;
                })

                ->addColumn('status', function ($folder) {
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
                })

                ->addColumn('action', function ($folder) {
                    $manageUrl = route('photo.folder', $folder->id);

                    return '
                        <a href="' . $manageUrl . '" class="btn btn-primary btn-sm">
                            Lihat Foto
                        </a>
                    ';
                })

                ->rawColumns(['file_path', 'status', 'action'])
                ->make(true);
        }

        return response()->json(['message' => 'Invalid request'], 400);
    }

    public function create()
    {
        $userId = Auth::id();

        $folders = FolderModel::where('user_id', $userId)->get();

        return view('dashboard.client.photo.create', compact('folders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'folder_id' => 'required|exists:folder,id',
            'photo_file.*' => 'required|image|max:5120'
        ]);

        $userId = Auth::id();

        FolderModel::where('id', $request->folder_id)
            ->where('user_id', $userId)
            ->firstOrFail();

        foreach ($request->file('photo_file') as $file) {

            $path = $file->store('photos', 'public');

            PhotoModel::create([
                'folder_id' => $request->folder_id,
                'file_path' => $path,
            ]);
        }

        return redirect()->route('photo.index')
            ->with('success', 'Foto berhasil diunggah.');
    }

    public function showFolder($folderId)
    {
        $userId = Auth::id();

        $folder = FolderModel::where('id', $folderId)
            ->where('user_id', $userId)
            ->firstOrFail();

        $photos = PhotoModel::where('folder_id', $folderId)
            ->orderBy('id', 'desc')
            ->get();

        return view('dashboard.client.photo.edit', compact('folder', 'photos'));
    }

    public function edit($id)
    {
        $userId = Auth::id();

        $photo = PhotoModel::where('id', $id)
            ->whereHas('folder', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->firstOrFail();

        $folders = FolderModel::where('user_id', $userId)->get();

        return view('photo.edit', compact('photo', 'folders'));
    }

    public function update(Request $request, $id)
    {
        $userId = Auth::id();

        $photo = PhotoModel::where('id', $id)
            ->whereHas('folder', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->firstOrFail();

        $request->validate([
            'folder_id' => 'required|exists:folder,id',
            'photo_file' => 'nullable|image|max:5120',
        ]);

        FolderModel::where('id', $request->folder_id)
            ->where('user_id', $userId)
            ->firstOrFail();

        $updateData = [
            'folder_id' => $request->folder_id
        ];

        if ($request->hasFile('photo_file')) {

            if (Storage::disk('public')->exists($photo->file_path)) {
                Storage::disk('public')->delete($photo->file_path);
            }

            $path = $request->file('photo_file')->store('photos', 'public');
            $updateData['file_path'] = $path;
        }

        $photo->update($updateData);

        return redirect()->route('photo.index')
            ->with('success', 'Foto berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $userId = Auth::id();

        $photo = PhotoModel::where('id', $id)
            ->whereHas('folder', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->firstOrFail();

        if (Storage::disk('public')->exists($photo->file_path)) {
            Storage::disk('public')->delete($photo->file_path);
        }

        $photo->delete();

        return redirect()->back()->with('success', 'Foto berhasil dihapus.');
    }

}
