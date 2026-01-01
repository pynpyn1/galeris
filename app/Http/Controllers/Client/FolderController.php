<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\FolderModel;
use App\Models\LinkModel;
use App\Models\PurchaseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class FolderController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        return view('dashboard.client.folder.read', compact('userId'));
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {

            $query = FolderModel::withTrashed()
                        ->where('user_id', Auth::id());

            return DataTables::of($query)->addIndexColumn()
                ->addColumn('status', function ($folder) {
                    if ($folder->deleted_at) {
                        $class = 'bg-warning';
                        $text = 'Deleted';
                    } else {
                        if ($folder->visibility === 'public') {
                            $class = 'bg-success';
                            $text = 'Public';
                        } else {
                            $class = 'bg-secondary';
                            $text = 'Private';
                        }
                    }
                    return "<span class=\"badge {$class}\">{$text}</span>";
                })
                   ->addColumn('action', function ($folder) {
                    $deleteUrl = route('folder.client.destroy', $folder->id);

                    $editUrl = route('folder.client.edit', $folder->id);

                    $editButton = '
                        <a href="' . $editUrl . '"
                            class="btn btn-info btn-sm me-2">
                            Edit
                        </a>
                    ';

                    $actions = $editButton;

                    if ($folder->deleted_at) {
                        $actions .= '<button type="button" class="btn btn-danger btn-sm" disabled>Deleted</button>';
                    } else {
                        $deleteForm = '
                            <form id="delete-form-' . $folder->id . '" action="' . $deleteUrl . '" method="POST" class="d-inline">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="button" class="btn btn-danger btn-sm delete-folder-btn" data-id="' . $folder->id . '">Delete</button>
                            </form>
                        ';
                        $actions .= $deleteForm;
                    }


                    return $actions;
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }

        return response()->json(['message' => 'Invalid request'], 400);
    }

    public function create()
    {
        $user = Auth::user();
        $folderName = $user->name_engaged . ' - Wedding Folder';

        return view('dashboard.client.folder.create', compact('folderName'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->activePurchase()->exists()) {

            $trialFolderCount = FolderModel::where('user_id', $user->id)
                ->where('is_trial', 1)
                ->count();

            if ($trialFolderCount >= 1) {
                abort(403, 'Free user hanya boleh memiliki 1 event');
            }
        }

        $hasActivePackage = PurchaseModel::where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->whereNotNull('subscription_start')
            ->where('subscription_end', '>', now())
            ->exists();


        if ($hasActivePackage) {
            $request->validate([
                'name'       => 'required|string|max:255',
                'date_event' => 'required|date|after_or_equal:today',
            ]);
        }


        if ($hasActivePackage) {
            $isTrial   = 0;
            $eventName = $request->name;
            $startDate = \Carbon\Carbon::parse($request->date_event);
        } else {
            $isTrial   = 1;
            $eventName = 'Demo Event';
            $startDate = now();
        }

        $endDate = $startDate->copy()->addWeeks(1);


        $folder = FolderModel::create([
            'user_id'        => $user->id,
            'client_id'      => $user->id,
            'name'           => $eventName,
            'visibility'     => 'public',
            'date_event'     => $startDate,
            'date_event_end' => $endDate,
            'is_trial'       => $isTrial,
        ]);


        LinkModel::create([
            'folder_id' => $folder->id,
            'user_id'   => $user->id,
            'client_id' => $user->id,
            'send_wa'   => 0,
        ]);

        return redirect()
            ->route('home.show', $folder->public_code)
            ->with(
                'success',
                $isTrial
                    ? 'Event trial berhasil dibuat.'
                    : 'Event berhasil dibuat.'
            );
    }



    public function edit($id)
    {
        $folder = FolderModel::withTrashed()->where('user_id', Auth::id())->findOrFail($id);

        return view('dashboard.client.folder.edit', compact('folder'));
    }

    public function update(Request $request, $id)
    {
        $folder = FolderModel::withTrashed()
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        if ($folder->trashed()) {
            $folder->restore();


        $links = $folder->link()->withTrashed()->get();

        foreach ($links as $link) {
            if ($link->trashed()) {
                $link->restore();
            }
        }
            return redirect()->route('folder.client.index')->with('success', 'Folder berhasil di-restore.');
        }

        $request->validate([
            'name'       => 'required|string|max:255',
            'visibility' => ['required', Rule::in(['public', 'private'])],
        ]);

        $oldVisibility = $folder->visibility;

        $folder->update([
            'name'       => $request->name,
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

        return redirect()->route('folder.client.index')->with('success', 'Folder berhasil diupdate.');
    }


    public function destroy($id)
    {
        $folder = FolderModel::where('user_id', Auth::id())->findOrFail($id);

        foreach ($folder->photos()->withTrashed()->get() as $photo) {

            if ($photo->file_path && \Storage::disk('public')->exists($photo->file_path)) {
                \Storage::disk('public')->delete($photo->file_path);
            }

            $photo->delete();
        }

        foreach ($folder->link()->withTrashed()->get() as $link) {

            if ($link->generate_qr_code && file_exists(public_path('qr/' . $link->generate_qr_code))) {
                unlink(public_path('qr/' . $link->generate_qr_code));
            }

            $link->delete();
        }

        $folder->delete();

        return redirect()
            ->route('folder.client.index')
            ->with('success', 'Folder, semua foto, link, dan QR berhasil dihapus permanen.');
    }

}
