<?php

namespace App\Http\Controllers;

use App\Models\ChatBotModel;
use App\Models\User;
use Illuminate\Http\Request;

class ChatBotController extends Controller
{
    public function index()
    {
        return view('dashboard.chatbot.read');
    }

    public function create()
    {
        $users = User::all();
        return view('dashboard.chatbot.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        ChatBotModel::create([
            'user_id' => $request->user_id,
            'message' => $request->message,
        ]);

        return redirect()->route('manage.chatbot.index')->with('success', 'ChatBot berhasil dibuat.');
    }

    public function edit($id)
    {
        $chatbot = ChatBotModel::withTrashed()->findOrFail($id);
        $users = User::withTrashed()->get();
        return view('dashboard.chatbot.edit', compact('chatbot', 'users'));
    }

    public function update(Request $request, $id)
    {
        $chatbot = ChatBotModel::withTrashed()->findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $chatbot->update([
            'user_id' => $request->user_id,
            'message' => $request->message,
        ]);

        if ($chatbot->trashed()) {
            $chatbot->restore();
            return redirect()->route('manage.chatbot.index')->with('success', 'ChatBot berhasil diperbarui dan dikembalikan.');
        }

        return redirect()->route('manage.chatbot.index')->with('success', 'ChatBot berhasil diperbarui.');
    }


    public function destroy(ChatBotModel $chatbot)
    {
        $chatbot->delete();
        return redirect()->route('manage.chatbot.index')->with('success', 'ChatBot berhasil dihapus.');
    }

    public function restore($id)
    {
        $chatbot = ChatBotModel::withTrashed()->findOrFail($id);
        $chatbot->restore();
        return redirect()->route('manage.chatbot.index')->with('success', 'ChatBot restored.');
    }
}
