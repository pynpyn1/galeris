<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_engaged',
        'profile_photo_path',
        'chatbot_status',
        'phone',
        'name',
        'email',
        'password',
        'role_group_id',
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
        static::created(function ($user) {

            ChatBotModel::create([
                'user_id' => $user->id,
                'message' => "Halo {$user->name}, QR kamu sudah dibuat!\n\n{url}"
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





}
