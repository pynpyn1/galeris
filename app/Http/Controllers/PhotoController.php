<?php

namespace App\Http\Controllers;

use App\Models\PhotoModel;
use App\Models\FolderModel; // Asumsi Anda punya FolderModel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use ZipArchive;

class PhotoController extends Controller
{

    public function index()
    {
        return view('dashboard.photo.read');
    }

    public function bulkDownload()
    {
        $photos = PhotoModel::all();

        if ($photos->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada foto yang tersedia untuk diunduh.');
        }

        $zipFileName = 'gallery_photos_' . now()->format('Ymd_His') . '.zip';
        $tempPath = storage_path('app/public/temp/');
        $zipPath = $tempPath . $zipFileName;

        if (!Storage::disk('public')->exists('temp')) {
            Storage::disk('public')->makeDirectory('temp');
        }

        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {

            foreach ($photos as $photo) {
                $filePath = \Storage::disk('public')->path($photo->file_path);
                $fileName = basename($photo->file_path);

                if (file_exists($filePath)) {
                    $zip->addFile($filePath, $fileName);
                } else {
                    \Log::warning("File foto tidak ditemukan: " . $photo->file_path);
                }
            }

            $zip->close();

            return response()->download($zipPath)->deleteFileAfterSend(true);

        } else {
            return redirect()->back()->with('error', 'Gagal membuat file arsip ZIP.');
        }
    }

    public function create()
    {
        $folders = FolderModel::where('visibility', 'public')->get();
        return view('dashboard.photo.create', compact('folders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'folder_id' => ['required', 'exists:folder,id'],
            'photo_file' => ['required'],
            'photo_file.*' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:5120'],
        ]);

        try {
            foreach ($request->file('photo_file') as $file) {

                $path = $file->store('photos', 'public');

                PhotoModel::create([
                    'folder_id'  => $request->folder_id,
                    'file_path'  => $path,
                    'file_name'  => basename($path),
                    'mime_type'  => $file->getClientMimeType(),
                    'size'       => $file->getSize(),
                ]);
            }

            return redirect()
                ->route('manage.photo.index')
                ->with('success', 'Semua foto berhasil diunggah.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan foto: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
       $folder = FolderModel::findOrFail($id);

    $photos = PhotoModel::where('folder_id', $id)
                ->orderBy('id', 'desc')
                ->get();

    return view('dashboard.photo.edit', compact('folder', 'photos'));
    }

    public function update(Request $request, $id)
    {
        $photo = PhotoModel::findOrFail($id);

        if ($photo->trashed()) {
            $photo->restore();
            return redirect()->route('manage.photo.index')->with('success', 'Foto berhasil di-restore dan diaktifkan kembali.');
        }

        $request->validate([
            'folder_id' => ['required', 'exists:folder,id'],
            'photo_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:5120'],
        ]);

        $updateData = ['folder_id' => $request->folder_id];

        if ($request->hasFile('photo_file')) {
            try {
                if (Storage::disk('public')->exists($photo->file_path)) {
                    Storage::disk('public')->delete($photo->file_path);
                }

                $path = $request->file('photo_file')->store('photos', 'public');
                $updateData['file_path'] = $path;

            } catch (\Exception $e) {
                return back()->withInput()->with('error', 'Gagal mengunggah file baru.');
            }
        }

        $photo->update($updateData);

        return redirect()->route('manage.photo.index')->with('success', 'Foto berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $photo = PhotoModel::findOrFail($id);

        try {

            if (Storage::disk('public')->exists($photo->file_path)) {
                Storage::disk('public')->delete($photo->file_path);
            }

            $photo->delete();

            return redirect()->route('manage.photo.index')->with('success', 'Foto berhasil dihapus (soft deleted).');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus foto: ' . $e->getMessage());
        }
    }
}
