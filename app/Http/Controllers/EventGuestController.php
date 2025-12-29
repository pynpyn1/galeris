<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventGuest;
use App\Models\EventGuestModel;
use App\Models\FolderModel;

class EventGuestController extends Controller
{
    public function store(Request $request, FolderModel $folder)
    {

        $number = $request->number;

        $number = preg_replace('/[^0-9]/', '', $number);

        if (substr($number, 0, 1) === '0') {
            $number = '62' . substr($number, 1);
        } elseif (substr($number, 0, 1) === '8') {
            $number = '62' . $number;
        }

        $request->merge(['number' => $number]);

        $request->validate([
            'name'   => 'required|string|max:255',
            'number' => 'required|string|min:10|max:16'
        ]);

        EventGuestModel::firstOrCreate(
            [
                'folder_id' => $folder->id,
                'number'    => $request->number,
            ],
            [
                'client_id' => $folder->user_id,
                'name'      => $request->name,
                'sent'      => false,
            ]
        );

        return back()->with('success', 'Nomor WhatsApp berhasil disimpan');
    }
}
