<?php

namespace App\Http\Controllers;

use App\Models\LinkModel;
use Illuminate\Http\Request;

class ProvidePhotoController extends Controller
{
    public function index($slug)
    {
        $link = LinkModel::with(['folder.photos', 'folder.videos'])
            ->where('slug', $slug)
            ->firstOrFail();

        $photos = $link->folder->photos ?? collect();
        $videos = $link->folder->videos ?? collect();

        $media = $photos->merge($videos)->sortByDesc('created_at');

        return view('media', compact('media', 'link'));
    }
}
