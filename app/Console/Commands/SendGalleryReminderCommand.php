<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EventGuestModel;
use App\Models\ChatBotModel;
use App\Models\LinkModel;
use App\Jobs\SendGalleryWhatsappJob;

class SendGalleryReminderCommand extends Command
{
    protected $signature = 'gallery:send-reminder';
    protected $description = 'Kirim WhatsApp reminder gallery ke tamu';

    public function handle()
    {
        $totalDispatched = 0;

        EventGuestModel::with(['client'])->where('sent', false)
            ->chunk(50, function ($guests) use (&$totalDispatched) {

                foreach ($guests as $guest) {

                    if (!$guest->client->wa_session_id || !$guest->number) {
                        continue;
                    }

                    $chatbot = ChatBotModel::where('user_id', $guest->client_id)->first();
                    if (!$chatbot) {
                        continue;
                    }

                    $link = LinkModel::where('folder_id', $guest->folder_id)
                        ->where('send_wa', true)
                        ->first();

                    if (!$link || !$link->generate_qr_code) {
                        continue;
                    }

                    $imagePath = public_path('qr/' . $link->generate_qr_code);
                    if (!file_exists($imagePath)) {
                        continue;
                    }

                    $message = str_replace(
                        ['{name}', '{url}'],
                        [
                            $guest->name,
                            config('app.url') . '/url/' . $link->slug
                        ],
                        $chatbot->message
                    );

                    SendGalleryWhatsappJob::dispatch(
                        $guest,
                        $message,
                        $imagePath
                    );

                    $guest->update(['sent' => true]);


                    $totalDispatched++;
                }
            });

        $this->info("Gallery reminder dispatched to {$totalDispatched} numbers");

        return Command::SUCCESS;
    }

}
