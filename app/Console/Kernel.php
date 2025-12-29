<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('gallery:send-reminder')->dailyAt('00.00');
        $schedule->command('folder:delete-expired-trial')->dailyAt('00.00');
        $schedule->command('purchase:expire-pending-purchases')->dailyAt('00.00');
        $schedule->command('purchase:expire-subscribe-purchases')->dailyAt('00.00');
        $schedule->command('discount:disable-expired-discounts')->dailyAt('00.00');
        $schedule->command('subscriptions:check')->dailyAt('00.00');

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
