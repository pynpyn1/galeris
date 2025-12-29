<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PurchaseModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Periksa langganan yang sudah kedaluwarsa, buat invoice auto-renew, dan kirim pengingat pembayaran.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();


        $expiredPurchases = PurchaseModel::where('subscription_status', 'active')
            ->where('subscription_end', '<=', $now)
            ->get();

        foreach ($expiredPurchases as $purchase) {
            if (!$purchase->auto_renew) {
                $purchase->update([
                    'subscription_status' => 'nonactive',
                    'subscription_start'  => null,
                    'subscription_end'    => null,
                    'next_payment_due_at' => null,
                ]);

                if (!$purchase->expired_email_sent) {
                    Mail::to($purchase->user->email)
                        ->send(new \App\Mail\SubscriptionExpiredMail($purchase));

                    $purchase->update(['expired_email_sent' => true]);
                }

                Log::info("Subscription expired and downgraded for user_id: {$purchase->user_id}");
            } else {

                $purchase->update(['subscription_status' => 'nonactive']);
                $this->generateAutoInvoice($purchase);
            }
        }


        $reminderPurchases = PurchaseModel::where('auto_renew', true)
            ->where('subscription_status', 'nonactive')
            ->where('payment_status', 'unpaid')
            ->where('next_payment_due_at', '>=', $now)
            ->where('next_payment_due_at', '<=', $now->copy()->addDays(3))
            ->where('reminder_sent', '<', 3)
            ->get();

        foreach ($reminderPurchases as $purchase) {
            Mail::to($purchase->user->email)
                ->send(new \App\Mail\ReminderInvoiceMail($purchase));

            $purchase->increment('reminder_sent');
            Log::info("Reminder email sent to user_id: {$purchase->user_id}, reminder count: {$purchase->reminder_sent}");
        }


        $expiredAutoInvoices = PurchaseModel::where('auto_renew', true)
            ->where('subscription_status', 'nonactive')
            ->where('payment_status', 'unpaid')
            ->where('next_payment_due_at', '<', $now)
            ->get();

        foreach ($expiredAutoInvoices as $invoice) {
            $invoice->delete();
            Log::info("Auto-renew invoice soft-deleted: {$invoice->invoice_number} for user_id: {$invoice->user_id}");

            if (!$invoice->expired_email_sent) {
                Mail::to($invoice->user->email)
                    ->send(new \App\Mail\InvoiceExpiredMail($invoice));

                $invoice->update(['expired_email_sent' => true]);
            }
        }

        $this->info('Subscriptions checked successfully!');
    }


    protected function generateAutoInvoice(PurchaseModel $purchase)
    {
        $existingInvoice = PurchaseModel::where('user_id', $purchase->user_id)
            ->where('subscription_status', 'nonactive')
            ->where('payment_status', 'unpaid')
            ->latest()
            ->first();

        if ($existingInvoice) {
            return;
        }

        $newPurchase = $purchase->replicate();
        $newPurchase->invoice_number = PurchaseModel::generateInvoiceNumber($purchase->user_id);
        $newPurchase->payment_status  = 'unpaid';
        $newPurchase->payment_proof  = null;
        $newPurchase->snap_status     = null;
        $newPurchase->snap_token      = null;
        $newPurchase->paid_at         = null;
        $newPurchase->subscription_start = null;
        $newPurchase->subscription_end   = null;
        $newPurchase->note   = null;
        $newPurchase->subscription_status = 'nonactive';

        if ($purchase->subscription_end) {
            $dueDate = Carbon::parse($purchase->subscription_end)->addDays(3);
        } else {
            $dueDate = now()->addDays(3);
        }
        $newPurchase->next_payment_due_at = $dueDate;

        $newPurchase->reminder_sent = 0;
        $newPurchase->invoice_email_sent = true;
        $newPurchase->save();

        Mail::to($newPurchase->user->email)
            ->send(new \App\Mail\ReminderInvoiceMail($newPurchase));

        Log::info("Auto-invoice created: {$newPurchase->invoice_number} for user_id: {$purchase->user_id}, due date: {$dueDate}");
    }

}
