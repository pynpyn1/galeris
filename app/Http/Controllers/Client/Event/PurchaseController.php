<?php

namespace App\Http\Controllers\Client\Event;

use App\Http\Controllers\Controller;
use App\Models\DiscountCodeModel;
use App\Models\PackageModel;
use App\Models\PurchaseModel;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Midtrans\Notification;
use Midtrans\Config;
use Midtrans\Snap;

class PurchaseController extends Controller
{
    public function select(Request $request)
    {
        $blocked = PurchaseModel::where('user_id', auth()->id())
            ->whereIn('payment_status', [
                'unpaid',
                'waiting_verification',
            ])
            ->exists();

        if ($blocked) {
            return redirect()
                ->route('home.subscribe')
                ->with('warning', 'Masih ada transaksi yang belum selesai.');
        }

        $request->validate([
            'package_id' => 'required|exists:package,id',
        ]);

        $package = PackageModel::findOrFail($request->package_id);

        $purchase = PurchaseModel::create([
            'user_id'         => auth()->id(),
            'package_id'      => $package->id,
            'original_price'  => $package->price,
            'discount_amount' => 0,
            'final_price'     => $package->price,
            'billing_cycle'   => 'monthly',
            'payment_method'  => 'manual',
            'payment_status'  => 'unpaid',
        ]);

        return redirect()->route('home.checkout.show', $purchase);
    }



    public function show(PurchaseModel $purchase)
    {
        abort_if($purchase->user_id !== auth()->id(), 403);

        if (in_array($purchase->payment_status, ['expired', 'rejected'])) {
            return redirect()
                ->route('home.subscribe')
                ->with('error', 'Transaksi ini sudah tidak berlaku.');
        }

        $badge = $purchase->paymentBadge();
        $hasActivePackage = PurchaseModel::with('package')
            ->where('user_id', auth()->id())
            ->active()
            ->first();

        return view(
            'dashboard.client.event.partials.subscribe.show',
            compact('purchase', 'badge', 'hasActivePackage')
        );
    }






    public function confirm(Request $request, PurchaseModel $purchase)
    {
        abort_if($purchase->user_id !== auth()->id(), 403);

        if ($purchase->payment_status !== 'unpaid') {
            return redirect()
                ->route('home.checkout.show', $purchase)
                ->with('warning', 'Transaksi ini sudah diproses.');
        }

        $request->validate([
            'payment_proof' => 'required|image|max:2048',
        ]);

        $path = $request->file('payment_proof')
            ->store('payment_proofs', 'public');

        $purchase->update([
            'payment_proof'  => $path,
            'payment_status' => 'waiting_verification',
        ]);

        return redirect()
            ->route('home.checkout.show', $purchase)
            ->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu verifikasi admin.');
    }

    public function applyDiscount(Request $request, PurchaseModel $purchase)
    {
        abort_if($purchase->user_id !== auth()->id(), 403);

        if ($purchase->payment_status !== 'unpaid') {

            return back()->withErrors(['code' => 'Transaksi sudah diproses']);
        }

        $request->validate([
            'code' => 'required|string'
        ]);

        $discount = DiscountCodeModel::where('code', $request->code)
            ->where('is_active', true)
            ->where(fn ($q) => $q->whereNull('start_at')->orWhere('start_at', '<=', now()))
            ->where(fn ($q) => $q->whereNull('end_at')->orWhere('end_at', '>=', now()))
            ->first();

        if (!$discount) {
            return back()->withErrors(['code' => 'Kode voucher tidak valid']);
        }


        if ($discount->quota !== null && $discount->quota <= 0) {

            return back()->withErrors(['code' => 'Kuota voucher habis']);
        }

        $used = auth()->user()
            ->discountCodes()
            ->where('discount_code_id', $discount->id)
            ->exists();

        if ($used) {
            return back()->withErrors(['code' => 'Kode voucher sudah digunakan']);
        }


        $price = $purchase->original_price;

        if ($discount->type === 'percent') {
            $percent = min($discount->value, 100);
            $discountAmount = round($price * $percent / 100);

            $calculationType = 'percent';
        } else {
            $discountAmount = min($discount->value, $price);
            $calculationType = 'fixed';
        }

        $finalPrice = max(0, $price - $discountAmount);


        $purchase->update([
            'discount_code_id' => $discount->id,
            'discount_amount'  => $discountAmount,
            'final_price'      => $finalPrice,
            'snap_token'       => null,
            'snap_status'      => null,
        ]);


        auth()->user()->discountCodes()->attach($discount->id, [
            'used_at' => now(),
        ]);


        if ($discount->quota !== null) {
            $discount->decrement('quota');

        }

        return back()->with('success', 'Voucher berhasil diterapkan!');
    }



    // Midtrans
    public function snapCheckout(PurchaseModel $purchase)
    {
        if ($purchase->snap_token && $purchase->snap_status === 'pending' && $purchase->snap_amount == $purchase->final_price) {
            return response()->json([
                'snapToken' => $purchase->snap_token
            ]);
        }


        if ($purchase->snap_status === 'success') {
            return response()->json([
                'error' => true,
                'message' => 'Transaksi sudah dibayar'
            ], 400);
        }

        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = true;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $purchase->invoice_number,
                'gross_amount' => $purchase->final_price,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
            'callbacks' => [
            'finish' => url('/payment/finish'),
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $purchase->update([
                'snap_token' => $snapToken,
                'snap_status' => 'pending',
                'snap_amount'    => $purchase->final_price,
                'payment_method' => 'midtrans',
            ]);

            return response()->json([
                'snapToken' => $snapToken
            ]);
        } catch (\Exception $e) {
            \Log::error('Midtrans Snap Error', [
                'invoice' => $purchase->invoice_number,
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'error' => true,
                'message' => 'Gagal memproses pembayaran'
            ], 500);
        }
    }








   public function webhook(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');

        $signature = hash('sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($signature !== $request->signature_key) {
            abort(403, 'Invalid signature');
        }

        $purchase = PurchaseModel::where('invoice_number', $request->order_id)->first();

        if (! $purchase) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $status = $request->transaction_status;


        if ($status === 'settlement') {

            if ($purchase->payment_status === 'paid') {
                return response()->json(['message' => 'Already processed']);
            }

            $start = now();
            $end   = now()->addMonth();

            $purchase->update([
                'payment_status'        => 'paid',
                'snap_status'           => 'success',
                'subscription_start'    => $start,
                'subscription_end'      => $end,
                'subscription_status'   => 'active',
            ]);

            return response()->json(['message' => 'Payment success']);
        }


        if ($status === 'pending') {
            $purchase->update([
                'snap_status' => 'pending'
            ]);
        }

        if (in_array($status, ['expire', 'cancel'])) {
            $purchase->update([
                'snap_status' => 'expired',
                'subscription_status' => 'nonactive'
            ]);
        }

        return response()->json(['ok' => true]);
    }








}
