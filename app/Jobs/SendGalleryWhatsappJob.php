<?php

namespace App\Jobs;

use App\Models\EventGuest;
use App\Models\GuestModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendGalleryWhatsappJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected GuestModel $guest;

    public function __construct(GuestModel $guest)
    {
        $this->guest = $guest;
    }

    public function handle()
    {
        if ($this->guest->sent) {
            return;
        }

        $galleryUrl = url('/gallery/' . $this->guest->folder_id);


        $message = "Halo 👋\n\n"
            . "Foto acara Anda sudah siap 📸\n\n"
            . "Silakan akses melalui link berikut:\n"
            . $galleryUrl . "\n\n"
            . "Terima kasih 🙏";


        app('whatsapp')->send(
            $this->guest->number,
            $message
        );

        $this->guest->update([
            'sent'    => true,
            'sent_at' => now()
        ]);
    }
}
