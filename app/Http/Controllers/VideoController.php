<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use ZipArchive;
use App\Models\FolderModel;
use App\Models\VideoModel;

class VideoController extends Controller
{
    public function index()
    {
        return view('dashboard.video.read');
    }

    public function create()
    {
        $folders = FolderModel::where('visibility', 'public')->get();
        return view('dashboard.video.create', compact('folders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'folder_id' => ['required', 'exists:folder,id'],
            'video_file' => ['required'],
            'video_file.*' => ['file', 'mimes:mp4,mov,avi,wmv,flv,webm', 'max:102400'],
        ]);

        try {
            foreach ($request->file('video_file') as $file) {

                $path = $file->store('videos', 'public');
                $user_id = auth()->id();

                VideoModel::create([
                    'folder_id'  => $request->folder_id,
                    'user_id'    => $user_id,
                    'file_path'  => $path,
                    'file_name'  => $file->getClientOriginalName(),
                    'mime_type'  => $file->getClientMimeType(),
                    'size'       => $file->getSize(),
                ]);
            }

            return redirect()
                ->route('manage.video.index')
                ->with('success', 'Semua video berhasil diunggah.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan video: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan video: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
       $folder = FolderModel::findOrFail($id);

    $videos = VideoModel::where('folder_id', $id)
                ->orderBy('id', 'desc')
                ->get();

    return view('dashboard.video.edit', compact('folder', 'videos'));
    }

    public function update(Request $request, $id)
    {
        $video = VideoModel::findOrFail($id);

        if ($video->trashed()) {
            return redirect()->route('manage.video.index')->with('success', 'Video berhasil di-restore dan diaktifkan kembali.');
        }

        $request->validate([
            'folder_id' => ['required', 'exists:folder,id'],
            'video_file' => ['nullable', 'file', 'mimes:mp4,mov,avi,wmv,flv,webm', 'max:102400'],
        ]);

        $updateData = ['folder_id' => $request->folder_id];

        if ($request->hasFile('video_file')) {
            try {
                if (Storage::disk('public')->exists($video->file_path)) {
                    Storage::disk('public')->delete($video->file_path);
                }

                $file = $request->file('video_file');

                $path = $file->store('videos', 'public');

                $updateData['file_path'] = $path;
                $updateData['file_name'] = $file->getClientOriginalName();
                $updateData['mime_type'] = $file->getClientMimeType();
                $updateData['size'] = $file->getSize();

            } catch (\Exception $e) {
                Log::error('Gagal mengunggah file video baru: ' . $e->getMessage());
                return back()->withInput()->with('error', 'Gagal mengunggah file baru.');
            }
        }

        $video->update($updateData);

        return redirect()->route('manage.video.index')->with('success', 'Video berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $video = VideoModel::findOrFail($id);

        try {
            if (Storage::disk('public')->exists($video->file_path)) {
                Storage::disk('public')->delete($video->file_path);
            }

            $video->delete();

            return redirect()->route('manage.video.index')->with('success', 'Video berhasil dihapus (soft deleted).');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus video: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus video: ' . $e->getMessage());
        }
    }
}
