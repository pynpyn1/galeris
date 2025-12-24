<?php

namespace App\Http\Controllers;

use App\Models\ChatBotModel;
use App\Models\FolderModel;
use App\Models\LinkModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class URLController extends Controller
{
    public function index()
    {
        return view('dashboard.url.read');
    }

    public function create()
    {
        $folders = FolderModel::where('visibility', 'public')->get();
        return view('dashboard.url.create', compact('folders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'folder_id' => 'required|exists:folder,id',
        ]);

        $folder = FolderModel::with('client')->findOrFail($request->folder_id);

        $client = $folder->client;
        if (!$client) {
            return redirect()->back()->with('error', 'Client tidak ditemukan untuk folder ini.');
        }

        $link = LinkModel::create([
            'folder_id' => $folder->id,
            'user_id'   => $folder->user_id,
            'client_id' => $client->id,
            'send_wa'   => $request->send_wa ?? 0,
        ]);

        $fullUrl = url("/url/" . $link->slug);

        if ($link->send_wa == 1) {
            $phone = $client->phone;
            $qrPath = public_path('qr/' . $link->generate_qr_code);

            $chatbot = ChatBotModel::where('user_id', $folder->user_id)->first();
            $caption = str_replace(['{name}', '{url}'], [$client->name_engaged, $fullUrl], $chatbot->message);

            \Log::info('Mengirim QR ke client via WA admin', [
                'user_id_sent_to_nodejs' => $folder->user_id,
                'client_id' => $client->id,
                'client_name' => $client->name_engaged,
                'phone' => $phone,
                'link_slug' => $link->slug,
                'qr_file' => $link->generate_qr_code,
                'caption' => $caption,
            ]);

            Http::attach(
                'file',
                file_get_contents($qrPath),
                $link->generate_qr_code
            )->post('http://localhost:3000/send-message-image', [
                'user_id' => $folder->user_id,
                'number'  => $phone,
                'caption' => $caption,
            ]);
        }

        return redirect()
            ->route('manage.url.index')
            ->with('success', 'URL berhasil dibuat dan QR dikirim ke client!');
    }






    public function destroy($id)
    {
        $link = LinkModel::findOrFail($id);

        if ($link->generate_qr_code && file_exists(public_path('qr/' . $link->generate_qr_code))) {
            unlink(public_path('qr/' . $link->generate_qr_code));
        }

        $link->delete();

        return redirect()
            ->route('manage.url.index')
            ->with('success', 'URL deleted successfully!');
    }

}
