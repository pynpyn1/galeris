<?php

namespace App\Http\Controllers\Client\Event;

use App\Http\Controllers\Controller;
use App\Models\FolderModel;
use App\Models\LinkModel;
use App\Models\PackageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class EventController extends Controller
{
    public function show(FolderModel $folder)
    {
        $user = auth()->user();


        if ($folder->user_id !== auth()->id()) {
            abort(403);
        }

        $link = $folder->link;

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

        $total_size_bytes = $user->usedStorageBytes();




        $formatted_size   = format_bytes($total_size_bytes, 1);
        $storage_limit_bytes = $user->storageLimitBytes();
        $limit_storage = $storage_limit_bytes === PHP_INT_MAX
            ? 'Unlimited'
            : format_bytes($storage_limit_bytes, 1);


        $upload_stats = [
            'image_count' => $image_count,
            'video_count' => $video_count,
            'total_size'  => $formatted_size,
            'limit_storage' => $limit_storage
        ];

        $can_download = $image_count >= 5 && $video_count >= 1;


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

        return response()->json(['success' => true, 'message' => 'Berhasil mengupdate']);
    }

    public function download(FolderModel $folder)
    {
        abort_if($folder->user_id !== auth()->id(), 403);

        $user = auth()->user();

        if (!$user->canDownloadHD()) {
            return back()->with('error', 'Paket Anda belum mendukung download.');
        }

        $zipName = 'event_' . $folder->id . '_' . now()->format('Ymd_His') . '.zip';
        $zipPath = storage_path('app/public/temp/' . $zipName);

        Storage::disk('public')->makeDirectory('temp');

        $zip = new ZipArchive;
        $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $manager = new ImageManager(new Driver());


        foreach ($folder->photos as $photo) {

            $originalPath = Storage::disk('public')->path($photo->file_path);

            if (!file_exists($originalPath)) continue;

            if ($user->canDownloadOriginal()) {
                $zip->addFile($originalPath, 'photos/' . basename($originalPath));
                continue;
            }

            // NON-PREMIUM → COMPRESS
            $image = $manager
                ->read($originalPath)
                ->scale(width: 1920)   // ❗ tidak gepeng
                ->toJpeg(75);

            $zip->addFromString(
                'photos/' . pathinfo($photo->file_name, PATHINFO_FILENAME) . '.jpg',
                (string) $image
            );
        }


        foreach ($folder->videos as $video) {
            $videoPath = Storage::disk('public')->path($video->file_path);
            if (!file_exists($videoPath)) continue;

            $zip->addFile($videoPath, 'videos/' . basename($videoPath));
        }

        $zip->close();

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }





}
