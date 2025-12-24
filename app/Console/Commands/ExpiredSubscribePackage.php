<?php

namespace App\Console\Commands;

use App\Models\PurchaseModel;
use Illuminate\Console\Command;

class ExpiredSubscribePackage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'purchase:expire-subscribe-purchases';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Masa Berlangganan Paket Habis';

    /**
     * Execute the console command.
     */
   public function handle()
    {
        $expired = PurchaseModel::where('payment_status', 'paid')
            ->whereNotNull('subscription_start')
            ->whereNotNull('subscription_end')
            ->where('subscription_status', 'active')
            ->where('subscription_end', '<=', now())
            ->update([
                'subscription_status' => 'nonactive',
            ]);

        $this->info("Expired {$expired} subscribe purchases.");
    }

}
