<?php

namespace App\Http\Controllers\Client\Event;

use App\Http\Controllers\Controller;
use App\Models\FolderModel;
use App\Models\LinkModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShareController extends Controller
{
    public function index(FolderModel $folder)
    {
        $link = $folder->links()->first();

        $url = url("/url/" . $link->slug);

        $qr_path = asset('qr/' . $link->generate_qr_code);

        return view('dashboard.client.event.share.index', [
            'event' => $folder,
            'url'   => $url,
            'link'  => $link,
            'qr_path' => $qr_path
        ]);
    }

    public function generateqr(FolderModel $folder, Request $request)
    {
        $link = $folder->links()->first();

        $svg = $request->file('qr_svg');

        $filename = 'qr_' . $link->id . '_' . time() . '.svg';
        $path = 'qr/' . $filename;

        Storage::disk('public')->put($path, file_get_contents($svg));

        $link->update([
            'generate_qr_code' => $filename
        ]);

        return response()->json([
            'success' => true,
            'qr_url' => asset('storage/' . $path)
        ]);
    }

    public function remind(FolderModel $folder, Request $request)
    {
        $request->validate([
            'send_wa' => 'required|boolean'
        ]);

        $link = $folder->links()->firstOrFail();

        $link->update([
            'send_wa' => $request->send_wa
        ]);

        return response()->json([
            'success' => true,
            'send_wa' => $link->send_wa
        ]);
    }


}
