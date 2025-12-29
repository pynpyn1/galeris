<?php

namespace App\Jobs;

use App\Models\EventGuestModel;
use App\Services\WhatsappService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendGalleryWhatsappJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $guestId;
    protected string $message;
    protected string $imagePath;

    public function __construct(EventGuestModel $guest, string $message, string $imagePath)
    {
        $this->guestId   = $guest->id;
        $this->message   = $message;
        $this->imagePath = $imagePath;
    }

    public function handle(WhatsappService $whatsapp): void
    {
        $guest = EventGuestModel::with('client')->find($this->guestId);

        if (!$guest || !$guest->client) {
            Log::error('[WA JOB] Guest / Client tidak ditemukan', [
                'guest_id' => $this->guestId,
            ]);
            return;
        }

        if (!$guest->client->wa_session_id) {
            Log::error('[WA JOB] wa_session_id NULL', [
                'guest_id'  => $guest->id,
                'client_id' => $guest->client_id,
            ]);
            return;
        }

        if (!$guest->number) {
            Log::error('[WA JOB] Nomor tamu kosong', [
                'guest_id' => $guest->id,
            ]);
            return;
        }

        $whatsapp->sendWithAttachment(
            $guest->client->wa_session_id,
            $guest->number,
            $this->message,
            $this->imagePath
        );

        $guest->update([
            'sent'    => true,
            'sent_at' => now(),
        ]);
    }
}
