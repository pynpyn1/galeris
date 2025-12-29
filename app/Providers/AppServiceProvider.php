<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\PurchaseModel;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('whatsapp', function () {
                return new \App\Services\WhatsappService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
         if (app()->environment('local')) {
            URL::forceScheme('http');
        }
        // View::composer('*', function ($view) {
        //     $pendingPurchase = null;

        //     if (auth()->check()) {
        //         $pendingPurchase = PurchaseModel::where('user_id', auth()->id())
        //             ->where('payment_status', 'pending')
        //             ->latest()
        //             ->first();
        //     }

        //     $view->with('pendingPurchase', $pendingPurchase);
        // });
    }
}
