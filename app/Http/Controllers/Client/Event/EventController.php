<?php

namespace App\Http\Controllers\Client\Event;

use App\Http\Controllers\Controller;
use App\Models\FolderModel;
use App\Models\LinkModel;
use App\Models\PackageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class EventController extends Controller
{
    public function show(FolderModel $folder)
    {
        if ($folder->user_id !== auth()->id()) {
            abort(403);
        }

        $link = $folder->links;

        if (!$link) {
            $link = LinkModel::create([
                'folder_id' => $folder->id,
                'user_id' => $folder->user_id,
                'client_id' => $folder->user_id,
            ]);
        }

        $qr_path = asset('qr/' . $link->generate_qr_code);


        $image_count = $folder->photos()->count();
        $video_count = $folder->videos()->count();

        $total_image_size = $folder->photos()->sum('size');
        $total_video_size = $folder->videos()->sum('size');
        $total_size_bytes = $total_image_size + $total_video_size;


        function formatBytes($bytes, $precision = 1) {
            if ($bytes === 0) return '0.0 GB';
            $units = array('B', 'KB', 'MB', 'GB', 'TB');
            $bytes = max($bytes, 0);
            $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
            $pow = min($pow, count($units) - 1);
            $bytes /= (1 << (10 * $pow));
            return round($bytes, $precision) . ' ' . $units[$pow];
        }

        $formatted_size = formatBytes($total_size_bytes, 1);

        $upload_stats = [
            'image_count' => $image_count,
            'video_count' => $video_count,
            'total_size'  => $formatted_size,
        ];

        $can_download = $image_count >= 5 && $video_count >= 5;


        $packages = PackageModel::orderBy('id')->get();

        return view('dashboard.client.event.index', [
            'event' => $folder,
            'link'    => $link,
            'qr_path' => $qr_path,
            'upload_stats' => $upload_stats,
            'can_download' => $can_download,
            'is_trial'  => $folder->is_trial,
            'packages' => $packages,
        ]);
    }

    public function update(Request $request, FolderModel $folder)
    {
        $validate = $request->validate([
            'name' => 'required|string',
        ],[
            'name.required' => 'Tolong inputkan nama untuk event anda!!!'
        ]);

        $folder->update($validate);

        return redirect()->back()->with('success', 'Berhasil mengubah nama acara');
    }


    public function thumbnail(Request $request, $id)
    {
        $request->validate([
            'thumbnail' => 'required|image|max:2048'
        ]);

        $event = FolderModel::findOrFail($id);
        $path = $request->file('thumbnail')->store('events', 'public');

        $event->thumbnail = asset('storage/'.$path);
        $event->save();

        return response()->json(['success' => true]);
    }

    public function download(FolderModel $folder)
    {
        if ($folder->user_id !== auth()->id()) {
            abort(403);
        }

        $imageCount = $folder->photos()->count();
        $videoCount = $folder->videos()->count();

        if ($imageCount < 5 || $videoCount < 5) {
            return back()->with('error', 'Minimal 5 foto dan 5 video untuk download.');
        }

        $zipName = 'uploads_' . $folder->id . '_' . now()->format('Ymd_His') . '.zip';
        $zipPath = storage_path('app/public/temp/' . $zipName);

        if (!Storage::disk('public')->exists('temp')) {
            Storage::disk('public')->makeDirectory('temp');
        }

        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {

            foreach ($folder->photos as $photo) {
                $filePath = Storage::disk('public')->path($photo->file_path);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, 'photos/' . basename($filePath));
                }
            }

            foreach ($folder->videos as $video) {
                $filePath = Storage::disk('public')->path($video->file_path);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, 'videos/' . basename($filePath));
                }
            }

            $zip->close();

            return response()->download($zipPath)->deleteFileAfterSend(true);
        }

        return back()->with('error', 'Gagal membuat file ZIP.');
    }




}
