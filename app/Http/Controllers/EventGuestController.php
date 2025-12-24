<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventGuest;
use App\Models\FolderModel;
use App\Models\GuestModel;

class EventGuestController extends Controller
{
    public function store(Request $request, FolderModel $folder)
    {
        $request->validate([
            'number' => 'required|string|min:9|max:15'
        ]);

        GuestModel::firstOrCreate(
            [
                'folder_id' => $folder->id,
                'number'    => $request->number,
            ],
            [
                'client_id' => $folder->user_id,
                'sent'      => false,
            ]
        );

        return back()->with('success', 'Nomor WhatsApp berhasil disimpan');
    }
}
