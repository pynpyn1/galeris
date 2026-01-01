<?php

namespace App\Http\Controllers\Client\Event;

use App\Http\Controllers\Controller;
use App\Models\FolderModel;
use App\Models\PhotoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class PhotoController extends Controller
{
    public function index(Request $request, FolderModel $folder)
    {
        $sort = $request->get('sort', 'latest');

        $photosQuery = $folder->photos();

        match ($sort) {
            'oldest' => $photosQuery->oldest('created_at'),
            'date'   => $photosQuery->orderByRaw('DATE(created_at) DESC'),
            'time'   => $photosQuery->orderByRaw('TIME(created_at) DESC'),
            default  => $photosQuery->latest('created_at'),
        };

        $photos = $photosQuery->paginate(10)->withQueryString();


        $usedStorage = auth()->user()->usedStorageBytes();
        $storageLimit = auth()->user()->storageLimitBytes();

        $storagePercent = $storageLimit > 0
            ? round(($usedStorage / $storageLimit) * 100, 2)
            : 0;


        return view('dashboard.client.event.upload.photo.index', [
            'event' => $folder,
            'photos' => $photos,
            'sort' => $sort,
            'usedStorage' => $usedStorage,
            'storageLimit' => $storageLimit,
            'storagePercent' => $storagePercent,
        ]);
    }


    public function store(Request $request, FolderModel $folder)
    {
        $request->validate([
            'photos'   => 'required|array',
            'photos.*' => 'image|mimes:jpg,jpeg,png,webp,heic|max:204800',
        ]);

        $user = auth()->user();
        $canOriginal = $user->canUploadOriginalResolution();

        foreach ($request->file('photos') as $file) {

            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = 'photos/' . $filename;

            if ($canOriginal) {
                Storage::disk('public')->put(
                    $path,
                    file_get_contents($file)
                );

                $size = $file->getSize();
            } else {
                $manager = new ImageManager(new Driver());

                $image = $manager
                    ->read($file)
                    ->scaleDown(width: 1920)
                    ->toJpeg(70);

                Storage::disk('public')->put($path, (string) $image);
                $size = strlen($image);
            }

            PhotoModel::create([
                'folder_id' => $folder->id,
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'mime_type' => 'image/jpeg',
                'size'      => $size,
            ]);
        }

        return back()->with('success', 'Foto berhasil diupload');
    }



    public function destroy(FolderModel $folder, PhotoModel $photo)
    {
        abort_if($photo->folder_id !== $folder->id, 403);

        Storage::disk('public')->delete($photo->file_path);
        $photo->delete();

        return back()->with('success', 'Foto berhasil dihapus');
    }

    public function destroyAll(FolderModel $folder)
    {
        $photos = $folder->photos()->get();


        if ($photos->isEmpty()) {
            return back()->with('warning', 'Tidak ada foto untuk dihapus.');
        }

        foreach ($photos as $photo) {
            Storage::disk('public')->delete($photo->file_path);
            $photo->delete();
        }

        return back()->with('success', 'Semua foto dalam event berhasil dihapus.');
    }


}
