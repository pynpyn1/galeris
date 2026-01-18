<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PurchaseModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('dashboard.invoice.read');
    }

    public function data(Request $request)
    {
       $query = PurchaseModel::with(['user', 'package'])->select('purchase.*')->orderByDesc('purchase.created_at');
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('invoice', function ($row) {
                return '<strong>' . $row->invoice_number . '</strong>';
            })
            ->addColumn('customer', function ($row) {
                return $row->user?->name ?? '-';
            })
            ->addColumn('package', function ($row) {
                return $row->package?->package_name ?? '-';
            })
            ->addColumn('price', function ($row) {
                return 'Rp ' . number_format($row->final_price, 0, ',', '.');
            })
            ->addColumn('status', function ($row) {
                $badge = $row->paymentBadge();

                if ($row->payment_status === 'unpaid') {
                    return '
                        <span class="badge '.$badge['class'].' opacity-75 cursor-not-allowed">
                            <i class="bi '.$badge['icon'].'"></i>
                            '.$badge['label'].'
                        </span>
                    ';
                }

                return '
                    <span
                        class="badge '.$badge['class'].' invoice-status cursor-pointer"
                        data-invoice="'.$row->invoice_number.'"
                        data-status="'.$row->payment_status.'"
                        data-method="'.$row->payment_method.'"
                        data-proof="'.($row->payment_proof ? asset('storage/'.$row->payment_proof) : '').'"
                        data-note="'.e($row->note).'">
                        <i class="bi '.$badge['icon'].'"></i>
                        '.$badge['label'].'
                    </span>
                ';
            })
            ->rawColumns(['invoice', 'status'])
            ->make(true);
    }


    public function edit(PurchaseModel $purchase)
    {
        return view('dashboard.invoice.edit', compact('purchase'));
    }

    public function update(Request $request, PurchaseModel $purchase)
    {
        $request->validate([
            'payment_status' => 'required|in:paid,rejected',
            'note' => 'nullable|string',
        ]);

        $data = [
            'payment_status' => $request->payment_status,
            'note' => $request->note,
        ];

        if ($request->payment_status === 'paid') {

            PurchaseModel::where('user_id', $purchase->user_id)
            ->where('id', '!=', $purchase->id)
            ->where('payment_status', 'paid')
            ->where('subscription_status', 'active')
            ->where('subscription_end', '>', now())
            ->update([
                'subscription_status' => 'nonactive',
                'subscription_end' => now(),
            ]);

            if (!$purchase->paid_at) {

                $start = now();

                $end = match ($purchase->billing_cycle) {
                    'monthly' => $start->copy()->addMonth(),
                    'yearly'  => $start->copy()->addYear(),
                    default   => null,
                };

                $data['paid_at'] = now();
                $data['subscription_status'] = 'active';
                $data['subscription_start'] = $start;
                $data['subscription_end']   = $end;
            }

        } else {
            $data['paid_at'] = null;
            $data['subscription_start'] = null;
            $data['subscription_end']   = null;
        }

        $purchase->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Status invoice berhasil diperbarui',
        ]);
    }

}
