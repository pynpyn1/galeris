<?php

namespace App\Http\Controllers\Client\Event;

use App\Http\Controllers\Controller;
use App\Models\LinkModel;
use Illuminate\Http\Request;

class GalleryWallController extends Controller
{
    public function index($slug)
    {
        $link = LinkModel::where('slug', $slug)
            ->with(['folder.photos'])
            ->firstOrFail();

        return view('livewall', [
            'photos' => $link->folder->photos->shuffle(),
            'link'   => $link,
            'canUseMusic' => $link->user->canUseCustomMusic(),
        ]);
    }
}
