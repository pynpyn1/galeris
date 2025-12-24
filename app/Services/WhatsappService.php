<?php

namespace App\Services;

class WhatsappService
{
    public function send(string $number, string $message): bool
    {
        // sementara dummy (log)
        \Log::info('WA SENT', [
            'number' => $number,
            'message' => $message
        ]);

        // kalau pakai provider:
        // return Http::post('API_WA', [...]);

        return true;
    }
}
