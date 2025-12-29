<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\PurchaseModel;

class InvoiceExpiredMail extends Mailable
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
        return $this->subject('Invoice Kadaluarsa')
                    ->markdown('emails.invoice_expired')
                    ->with([
                        'userName' => $this->purchase->user->name,
                        'invoiceNumber' => $this->purchase->invoice_number,
                        'amount' => number_format($this->purchase->final_price, 0, ',', '.'),
                    ]);
    }
}
