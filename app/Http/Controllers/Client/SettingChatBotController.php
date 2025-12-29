<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ChatBotModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SettingChatBotController extends Controller
{
    public function index()
    {
        return view('dashboard.client.chatbot.read');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $query = ChatBotModel::with('user')->where('user_id', Auth::id())->withTrashed();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('user', fn($row) => optional($row->user)->name ?? '-')
                ->addColumn('message', fn($row) => $row->message ?? '-')
                ->addColumn('status', fn($row) => $row->deleted_at
                    ? '<span class="badge bg-warning">Deleted</span>'
                    : '<span class="badge bg-success">Active</span>')
                ->addColumn('action', function ($row) {
                    $editUrl = route('chatbot.edit', $row->id);

                    $editButton = '<a href="' . $editUrl . '" class="btn btn-info btn-sm me-1">Edit</a>';


                    return $editButton;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return response()->json(['message' => 'Invalid Request'], 400);
    }

    public function edit($id)
    {
        $chatbot = ChatBotModel::withTrashed()->findOrFail($id);
        return view('dashboard.client.chatbot.edit', compact('chatbot', ));
    }

    public function update(Request $request, $id)
    {
        $chatbot = ChatBotModel::withTrashed()->findOrFail($id);

        if (!auth()->user()->canEditChatbot()) {
            return back()->with('error', 'Paket Anda belum mendukung fitur ini.');
        }

        $request->validate([
            'message' => 'required|string',
        ]);

        $chatbot->update([
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        if ($chatbot->trashed()) {
            $chatbot->restore();
            return redirect()->route('chatbot.index')->with('success', 'ChatBot berhasil diperbarui dan dikembalikan.');
        }

        return redirect()->route('home.index')->with('success', 'Message berhasil diperbarui.');
    }
}
