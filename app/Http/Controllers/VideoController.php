<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use ZipArchive;

// Impor Model yang diperlukan
use App\Models\FolderModel;
use App\Models\VideoModel; // Hanya menggunakan VideoModel

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


    /**
     * Memperbarui video tunggal.
     */
    public function update(Request $request, $id)
    {
        // Menggunakan VideoModel
        $video = VideoModel::findOrFail($id);

        if ($video->trashed()) {
            return redirect()->route('manage.video.index')->with('success', 'Video berhasil di-restore dan diaktifkan kembali.');
        }

        // Validasi untuk file video baru
        $request->validate([
            'folder_id' => ['required', 'exists:folder,id'],
            'video_file' => ['nullable', 'file', 'mimes:mp4,mov,avi,wmv,flv,webm', 'max:102400'], // Validasi file video
        ]);

        $updateData = ['folder_id' => $request->folder_id];

        // Mengubah dari 'photo_file' menjadi 'video_file'
        if ($request->hasFile('video_file')) {
            try {
                // Hapus file lama
                if (Storage::disk('public')->exists($video->file_path)) {
                    Storage::disk('public')->delete($video->file_path);
                }

                $file = $request->file('video_file');

                // Mengubah folder penyimpanan
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


    /**
     * Menghapus video tunggal.
     */
    public function destroy($id)
    {
        // Menggunakan VideoModel
        $video = VideoModel::findOrFail($id);

        try {
            // Hapus file dari storage
            if (Storage::disk('public')->exists($video->file_path)) {
                Storage::disk('public')->delete($video->file_path);
            }

            // Soft delete record
            $video->delete();

            return redirect()->route('manage.video.index')->with('success', 'Video berhasil dihapus (soft deleted).');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus video: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus video: ' . $e->getMessage());
        }
    }
}
