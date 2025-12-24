<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EventGuest;
use App\Jobs\SendGalleryWhatsappJob;
use App\Models\GuestModel;

class SendGalleryReminderCommand extends Command
{
    protected $signature = 'gallery:send-reminder';
    protected $description = 'Kirim WhatsApp reminder gallery ke guest';

    public function handle()
    {
        GuestModel::where('sent', false)
            ->whereDate('created_at', '<=', now()->subDay())
            ->chunk(50, function ($guests) {
                foreach ($guests as $guest) {
                    SendGalleryWhatsappJob::dispatch($guest);
                }
            });

        $this->info('Gallery reminder dispatched');
    }
}
