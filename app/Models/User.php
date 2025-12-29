<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'profile_photo_path',
        'chatbot_status',
        'phone',
        'name',
        'email',
        'password',
        'role_group_id',
        'wa_session_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->wa_session_id)) {
                $user->wa_session_id = Str::uuid();
            }
        });

        static::created(function ($user) {
            ChatBotModel::create([
                'user_id' => $user->id,
                'message' => "Halo Kak {name},\n\nTerima kasih telah hadir dan memeriahkan acara kami!\n\nFoto-foto keseruan acara tadi sudah bisa dilihat dan diunduh. Yuk, cek momen-momennya di galeri berikut:\n{url}\n\nSelamat menikmati kenangannya!"
            ]);
        });

        static::restored(function ($user) {
            ChatBotModel::create([
                'user_id' => $user->id,
                'message' => "Halo Kak {name},\n\nTerima kasih telah hadir dan memeriahkan acara kami!\n\nFoto-foto keseruan acara tadi sudah bisa dilihat dan diunduh. Yuk, cek momen-momennya di galeri berikut:\n{url}\n\nSelamat menikmati kenangannya!"
            ]);
        });
    }


    public function createdFolders()
    {
        return $this->hasMany(FolderModel::class, 'user_id', 'id');
    }

    public function assignedFolders()
    {
        return $this->hasMany(FolderModel::class, 'client_id', 'id');
    }


    public function roleGroup()
    {
        return $this->belongsTo(RoleGroupModel::class, 'role_group_id', 'id');
    }

   public function discountCodes()
    {
        return $this->belongsToMany(
            DiscountCodeModel::class,
            'user_discount_code',
            'user_id',
            'discount_code_id'
        )
        ->withPivot('used_at')
        ->withTimestamps();
    }


    public function folderpackage()
    {
        return $this->hasMany(FolderPackageModel::class, 'user_id', 'id');
    }


    public function hasPermissionTo($permissionName)
    {
        return $this->roleGroup->permissions()->where('slug', $permissionName)->exists();
    }

    public function activePurchase()
    {
        return $this->hasOne(PurchaseModel::class)
            ->active()
            ->latest('subscription_end');
    }

    public function usedStorageBytes(): int
    {
        $photoSize = PhotoModel::whereHas('folder', function ($q) {
            $q->where('user_id', $this->id);
        })->sum('size');

        $videoSize = VideoModel::whereHas('folder', function ($q) {
            $q->where('user_id', $this->id);
        })->sum('size');

        return $photoSize + $videoSize;
    }


    public function storageLimitBytes(): int
    {
        $purchase = $this->activePurchase;

        if (!$purchase || !$purchase->package) {
            return 100 * 1024 * 1024;
        }

        if ($purchase->package->is_unlimited) {
            return PHP_INT_MAX;
        }

        return $purchase->package->storage_limit_gb * 1024 * 1024 * 1024;
    }

    public function canUploadOriginalResolution(): bool
    {
        $purchase = $this->activePurchase;

        if (!$purchase || !$purchase->package) {
            return false;
        }

        return in_array($purchase->package->plan, ['pro', 'premium']);
    }

    public function canDownloadOriginal(): bool
    {
        $purchase = $this->activePurchase;
        return $purchase && $purchase->package->plan === 'premium';
    }

    public function canDownloadHD(): bool
    {
        $purchase = $this->activePurchase;
        return in_array($purchase?->package->plan, ['beginner', 'basic', 'pro', 'premium']);
    }

    public function canEditChatbot(): bool
    {
        $package = $this->activePurchase?->package?->plan;

        return in_array($package, ['pro', 'premium']);
    }

    public function canUseCustomMusic(): bool
    {
        $plan = $this->activePurchase?->package?->plan;

        return in_array($plan, ['pro', 'premium']);
    }


}
