<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class PurchaseModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'purchase';
    protected $fillable = [
        'user_id',
        'package_id',
        'discount_code_id',
        'invoice_number',
        'original_price',
        'discount_amount',
        'final_price',
        'billing_cycle',
        'subscription_start',
        'subscription_end',
        'subscription_status',
        'payment_method',
        'payment_status',
        'snap_token',
        'snap_status',
        'snap_amount',
        'payment_reference',
        'payment_proof',
        'paid_at',
        'note',
    ];

    protected $casts = [
        'subscription_start' => 'datetime',
        'subscription_end'   => 'datetime',
        'paid_at'            => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($purchase) {

            if (!$purchase->invoice_number) {
                $purchase->invoice_number = self::generateInvoiceNumber();
            }

    });
    }

    /**
     * Format:
     * INV-20251218-USERID-XXXX
     */
    public static function generateInvoiceNumber(): string
    {
        return 'INV-'
            . now()->format('Ymds')
            . '-'
            . auth()->id()
            . '-'
            . 'G'
            . strtoupper(Str::random(3));
    }


    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function package()
    {
        return $this->belongsTo(PackageModel::class, 'package_id', 'id');
    }

    public function discount()
    {
        return $this->belongsTo(DiscountCodeModel::class, 'discount_code_id');
    }


    public function getRouteKeyName()
    {
        return 'invoice_number';
    }

    public function scopeActive($query)
    {
        return $query->where('payment_status', 'paid')
            ->where('subscription_status', 'active')
            ->where('subscription_end', '>', now());
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function isPending(): bool
    {
        return $this->payment_status === 'unpaid';
    }

    public function paymentBadge(): array
    {
        return match ($this->payment_status) {
            'unpaid' => [
                'label' => 'Menunggu Pembayaran',
                'class' => 'bg-warning text-dark',
                'icon'  => 'bi-clock-history',
            ],

            'waiting_verification' => [
                'label' => 'Menunggu Verifikasi',
                'class' => 'bg-info text-light',
                'icon'  => 'bi-hourglass-split',
            ],

            'paid' => [
                'label' => 'Pembayaran Diterima',
                'class' => 'bg-success',
                'icon'  => 'bi-check-circle',
            ],

            'expired' => [
                'label' => 'Pembayaran Kedaluwarsa',
                'class' => 'bg-danger',
                'icon'  => 'bi-x-circle',
            ],
            'rejected' => [
                'label' => 'Pembayaran Ditolak',
                'class' => 'bg-danger',
                'icon'  => 'bi-x-circle',
            ],

            default => [
                'label' => 'Status Tidak Diketahui',
                'class' => 'bg-secondary',
                'icon'  => 'bi-question-circle',
            ],
        };
    }





}
