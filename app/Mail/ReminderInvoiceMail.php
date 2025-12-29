<?php

namespace App\Mail;

use App\Models\PurchaseModel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReminderInvoiceMail extends Mailable
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
        return $this->subject('Pengingat Pembayaran Invoice #' . $this->purchase->invoice_number)
                    ->markdown('emails.reminder_invoice')
                    ->with([
                        'purchase' => $this->purchase,
                    ]);
    }
}
