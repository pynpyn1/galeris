<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\PurchaseModel;

class SubscriptionExpiredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $purchase;

    /**
     * Create a new message instance.
     */
    public function __construct(PurchaseModel $purchase)
    {
        $this->purchase = $purchase;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Paket Langganan Anda Telah Berakhir')
                    ->markdown('emails.subscription_expired')
                    ->with([
                        'userName' => $this->purchase->user->name,
                        'packageName' => $this->purchase->package->package_name ?? 'Paket Anda',
                    ]);
    }
}
