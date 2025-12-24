<?php

namespace App\Console\Commands;

use App\Models\PurchaseModel;
use Illuminate\Console\Command;

class ExpirePendingPurchases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:expire-pending-purchases';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire pending purchases older than 24 hours';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expired = PurchaseModel::where('payment_status', 'unpaid')
                    ->whereNull('payment_proof')
                    ->where('created_at', '<', now()->subHours(24))
                    ->update([
                        'payment_status' => 'expired',
                    ]);
        $this->info("Expired {$expired} unpaid purchases.");
    }

}
