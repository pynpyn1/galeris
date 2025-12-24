<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createTransaction($purchase)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $purchase->invoice_number,
                'gross_amount' => $purchase->final_price,
            ],
            'customer_details' => [
                'first_name' => $purchase->user->name,
                'email' => $purchase->user->email,
            ],
        ];

        return Snap::getSnapToken($params);
    }
}
