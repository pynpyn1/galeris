<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\FolderModel;
use App\Models\User;
use Illuminate\Http\Request;

class WhatsappController extends Controller
{
    public function toggle(Request $request, User $user)
    {
            $validatedData = $request->validate([
                'chatbot_status' => 'required|in:1,0'
            ]);

            $user->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Whatsapp status updated',
                'chatbot_status' => $user->chatbot_status
            ]);
    }
}
