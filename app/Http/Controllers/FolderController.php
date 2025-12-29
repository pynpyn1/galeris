<?php

namespace App\Http\Controllers;

use App\Models\FolderModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\Rule;

class FolderController extends Controller
{
    public function index()
    {
        return view('dashboard.folder.read');
    }

    public function create()
    {
        $clients = User::where('role_group_id', 2)->get();

        return view('dashboard.folder.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'visibility' => 'required|in:public,private',
        ]);

        $startDate = Date::now();
        $endDate = $startDate->copy()->addWeeks(2);

        FolderModel::create([
            'user_id' => Auth::id(),
            'client_id' => $request->client_id,
            'name' => $request->name,
            'visibility' => $request->visibility,
            'date_event' => $startDate,
            'date_event_end' => $endDate,
        ]);

        return redirect()->route('manage.folder.index')->with('success', 'Folder berhasil dibuat.');
    }

    public function edit($id)
    {

        $folder = FolderModel::withTrashed()->findOrFail($id);
        $clients = User::where('role_group_id', 2)->get();

        return view('dashboard.folder.edit', compact('folder', 'clients'));

    }

    public function update(Request $request, $id)
    {
        $folder = FolderModel::withTrashed()->findOrFail($id);

        if ($folder->trashed()) {
            $folder->restore();



            $links = $folder->link()->withTrashed()->get();
            foreach ($links as $link) {
                if ($link->trashed()) $link->restore();
            }
            return redirect()->route('manage.folder.index')->with('success', 'Folder berhasil di-restore.');
        }

        $request->validate([
            'name' => 'required',
            'user_id' => 'required|exists:users,id',
            'visibility' => ['required', Rule::in(['public', 'private'])],
        ]);

        $oldVisibility = $folder->visibility;

        $folder->update([
            'name' => $request->name,
            'visibility' => $request->visibility,
        ]);

        $photos = $folder->photos()->withTrashed()->get();
        $links  = $folder->link()->withTrashed()->get();

        if ($oldVisibility === 'public' && $request->visibility === 'private') {

            foreach ($photos as $photo) {
                if (!$photo->trashed()) {
                    $photo->delete();
                }
            }

            foreach ($links as $link) {
                if (!$link->trashed()) {
                    $link->delete();
                }
            }
        }

        if ($oldVisibility === 'private' && $request->visibility === 'public') {

            foreach ($photos as $photo) {
                if ($photo->trashed()) {
                    $photo->restore();
                }
            }

            foreach ($links as $link) {
                if ($link->trashed()) {
                    $link->restore();
                }
            }
        }

        return redirect()->route('manage.folder.index')->with('success', 'Folder berhasil diupdate.');
    }



    public function destroy(FolderModel $folder)
    {
        $photos = $folder->photos()->withTrashed()->get();

        foreach ($photos as $photo) {
            if ($photo->file_path && \Storage::disk('public')->exists($photo->file_path)) {
                \Storage::disk('public')->delete($photo->file_path);
            }

            $photo->delete();
        }


        $links = $folder->link()->withTrashed()->get();

        foreach ($links as $link) {

            if ($link->generate_qr_code && file_exists(public_path('qr/' . $link->generate_qr_code))) {
                unlink(public_path('qr/' . $link->generate_qr_code));
            }

            $link->delete();
        }


        $deleted = $folder->delete();

        if ($deleted) {
            return redirect()
                ->route('manage.folder.index')
                ->with('success', 'Folder, semua foto, dan semua link berhasil dihapus.');
        }

        return redirect()
            ->route('manage.folder.index')
            ->with('error', 'Gagal menghapus folder.');
    }


}
