<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\FolderModel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\ChatBotModel;

class SendReminderWa extends Command
{
    protected $signature = 'wa:send-reminder';
    protected $description = 'Send WhatsApp reminder 2 days after event';

    public function handle()
    {
        $folders = FolderModel::whereDate(
            'date_event_end',
            '<=',
            Carbon::now()->subDays(2)
        )->get();

        foreach ($folders as $folder) {

            $link = $folder->links()->first();

            if (!$link || $link->send_wa != 1 || $link->wa_sent == 1) {
                continue;
            }

            $client = $folder->client;

            if (!$client || !$client->phone) {
                Log::warning('Client or phone missing', [
                    'folder_id' => $folder->id
                ]);
                continue;
            }

            $qrPath = public_path('qr/' . $link->generate_qr_code);

            if (!file_exists($qrPath)) {
                Log::warning('QR not found', [
                    'folder_id' => $folder->id,
                    'qr' => $qrPath
                ]);
                continue;
            }

            $fullUrl = url('/url/' . $link->slug);

            $chatbot = ChatBotModel::where('user_id', $folder->user_id)->first();

            if (!$chatbot) {
                Log::warning('Chatbot not found', [
                    'user_id' => $folder->user_id
                ]);
                continue;
            }

            $caption = str_replace(
                ['{name}', '{url}'],
                [$client->name_engaged, $fullUrl],
                $chatbot->message
            );

            Log::info('Sending WA reminder', [
                'folder_id' => $folder->id,
                'client_id' => $client->id,
                'phone' => $client->phone
            ]);

            Http::attach(
                'file',
                file_get_contents($qrPath),
                $link->generate_qr_code
            )->post('http://localhost:3000/send-message-image', [
                'user_id' => $folder->user_id,
                'number'  => $client->phone,
                'caption' => $caption,
            ]);

            $link->update([
                'wa_sent' => 1,
                'wa_sent_at' => now()
            ]);
        }

        return Command::SUCCESS;
    }
}
