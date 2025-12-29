<?php

namespace App\Http\Controllers;

use App\Mail\ContactUsMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HelpController extends Controller
{
    public function tos()
    {
        return view('help.tos');
    }

    public function privacy()
    {
        return view('help.privacy');
    }

    public function index()
    {
        return view('help.contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Mail::send(new ContactUsMail($validated));

        return redirect()->back()->with('success', 'Pesan berhasil dikirim!');
    }

}
