<?php

namespace App\Http\Controllers\Client\Event;

use App\Http\Controllers\Controller;
use App\Models\FolderModel;
use App\Models\VideoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index(Request $request, FolderModel $folder)
    {
        $sort = $request->get('sort', 'latest');

        $videosQuery = $folder->videos();

        match ($sort) {
            'oldest' => $videosQuery->oldest('created_at'),
            'date'   => $videosQuery->orderByRaw('DATE(created_at) DESC'),
            'time'   => $videosQuery->orderByRaw('TIME(created_at) DESC'),
            default  => $videosQuery->latest('created_at'),
        };

        $videos = $videosQuery->paginate(10)->withQueryString();


        $usedStorage = auth()->user()->usedStorageBytes();
        $storageLimit = auth()->user()->storageLimitBytes();

        $storagePercent = $storageLimit > 0
            ? round(($usedStorage / $storageLimit) * 100, 2)
            : 0;


        return view('dashboard.client.event.upload.video.index', [
            'event' => $folder,
            'videos' => $videos,
            'sort' => $sort,
            'usedStorage' => $usedStorage,
            'storageLimit' => $storageLimit,
            'storagePercent' => $storagePercent,
        ]);
    }


   public function store(Request $request, FolderModel $folder)
    {
        $request->validate([
            'videos'   => 'required|array|min:1',
            'videos.*' => 'file|mimes:mkv,mp4',
        ]);

        $user = auth()->user();

        $usedStorage   = $user->usedStorageBytes();
        $storageLimit  = $user->storageLimitBytes();

        $uploadSize = collect($request->file('videos'))
            ->sum(fn ($file) => $file->getSize());

        if (($usedStorage + $uploadSize) > $storageLimit) {
            $remaining = max($storageLimit - $usedStorage, 0);

            return back()->with('error',
                'Storage tidak mencukupi. Sisa kapasitas Anda hanya ' .
                round($remaining / 1024 / 1024, 2) . ' MB.'
            );
        }

        foreach ($request->file('videos') as $file) {
            $path = $file->store('videos', 'public');

            VideoModel::create([
                'folder_id' => $folder->id,
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size'      => $file->getSize(),
            ]);
        }

        return back()->with('success', 'Video berhasil diupload');
    }



    public function destroy(FolderModel $folder, VideoModel $video)
    {
        abort_if($video->folder_id !== $folder->id, 403);

        Storage::disk('public')->delete($video->file_path);
        $video->delete();

        return back()->with('success', 'Video berhasil dihapus');
    }

    public function destroyAll(FolderModel $folder)
    {
        $videos = $folder->videos()->get();


        if ($videos->isEmpty()) {
            return back()->with('warning', 'Tidak ada video untuk dihapus.');
        }

        foreach ($videos as $video) {
            Storage::disk('public')->delete($video->file_path);
            $video->delete();
        }

        return back()->with('success', 'Semua video dalam event berhasil dihapus.');
    }


}
