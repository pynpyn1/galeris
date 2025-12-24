<?php

namespace App\Console\Commands;

use App\Models\DiscountCodeModel;
use Illuminate\Console\Command;

class DisableExpiredDiscounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discount:disable-expired-discounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menonaktifkan diskon yang kuotanya sudah habis';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $affected = DiscountCodeModel::whereNotNull('quota')
            ->where('quota', '<=', 0)
            ->where('is_active', true)
            ->update([
                'is_active' => false
            ]);

        $this->info("{$affected} diskon berhasil dinonaktifkan.");
    }
}
