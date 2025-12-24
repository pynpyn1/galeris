<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\FolderModel;
use App\Models\LinkModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;

class QrCodeController extends Controller
{
    public function index()
    {
        return view('dashboard.client.qrcode.read');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $authUser = Auth::user()->id;
             $query = LinkModel::withTrashed()
            ->where('user_id', $authUser)
            ->with(['folder' => function ($q) {
                $q->withTrashed();
            }])
            ->get();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('url', function ($item) {

                    if (!$item->slug) return '-';

                    $redirectUrl = url('/url/' . $item->slug);

                    if ($item->deleted_at) {
                        return '<button class="btn btn-outline-primary btn-sm" disabled>URL Disabled</button>';
                    }

                    return '<a href="'.$redirectUrl.'" target="_blank" class="btn btn-outline-primary btn-sm">
                                View URL
                            </a>';
                })->addColumn('folder_name', function ($item) {
                    return $item->folder->name ?? '-';
                })->addColumn('qr', function ($item) {
                    if ($item->generate_qr_code) {

                            $qrPath = public_path('qr/' . $item->generate_qr_code);

                            if (!file_exists($qrPath)) {
                                return '<img src="' . asset('asset/img/404.jpeg') . '" width="50">';
                            }

                            return '<img src="' . asset('qr/' . $item->generate_qr_code) . '" width="50">';
                        }

                    return '<img src="' . asset('asset/img/404.jpeg') . '" width="50">';
                })->addColumn('status', function ($item) {
                    if ($item->deleted_at) {
                        return '<span class="badge bg-warning">Deleted</span>';
                    }
                    return '<span class="badge bg-success">Active</span>';
                })->addColumn('action', function ($item) {
                    if ($item->deleted_at) {
                        return '<button class="btn btn-danger btn-sm" disabled>Deleted</button>';
                    }

                    $deleteUrl = route('qrcode.destroy', $item->id);

                    return '
                        <form id="delete-form-'.$item->id.'" action="'.$deleteUrl.'" method="POST" class="d-inline">
                            '.csrf_field().method_field('DELETE').'
                            <button type="button" class="btn btn-danger btn-sm delete-url-btn" data-id="'.$item->id.'">
                                Delete
                            </button>
                        </form>
                    ';
                })
                ->rawColumns(['qr', 'status', 'action','url'])
                ->make(true);
        }

        return response()->json(['message' => 'Invalid request'], 400);
    }

    public function create()
    {
        $folders = FolderModel::where('user_id', Auth::id())
                ->where('visibility', 'public')
                ->get();
        return view('dashboard.client.qrcode.create', compact('folders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'folder_id' => 'required|exists:folder,id',
        ]);

        $user = Auth::user();

        $folder = FolderModel::findOrFail($request->folder_id);

        $link = LinkModel::create([
            'folder_id' => $folder->id,
            'user_id'   => $user->id,
            'client_id' => $user->id,
            'send_wa'   => $request->send_wa ?? 0,
        ]);

        $fullUrl = url("/url/" . $link->slug);

        if ($link->send_wa == 1) {
            $phone = $user->phone;
            $qrPath = public_path('qr/' . $link->generate_qr_code);

            $chatbot = \App\Models\ChatBotModel::where('user_id', $folder->user_id)->first();
            $caption = $chatbot
                ? str_replace(['{name}', '{url}'], [$user->name, $fullUrl], $chatbot->message)
                : "Halo {$user->name}, QR kamu sudah dibuat!\n\n{$fullUrl}";

            $response = Http::attach(
                'file',
                file_get_contents($qrPath),
                $link->generate_qr_code
            )->post('http://localhost:3000/send-message-image', [
                'user_id' => $user->id,
                'number'  => $phone,
                'caption' => $caption,
            ]);

            \Log::info('Response Node WA', [
                'status' => $response->status(),
                'body' => $response->body(),
                'link_id' => $link->id,
                'user_id' => $user->id,
            ]);
        }

        return redirect()
            ->route('qrcode.index')
            ->with('success', 'QR berhasil dibuat dan dikirim (jika WA aktif).');
    }





    public function destroy($id)
    {
        $link = LinkModel::findOrFail($id);

        if ($link->generate_qr_code && file_exists(public_path('qr/' . $link->generate_qr_code))) {
            unlink(public_path('qr/' . $link->generate_qr_code));
        }

        $link->delete();

        return redirect()
            ->route('qrcode.index')
            ->with('success', 'QR Berhasil dihapus.');
    }

}
