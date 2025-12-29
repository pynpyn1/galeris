<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FolderModel extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'folder';
    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($folder) {
            $folder->public_code = Str::random(4);
        });
    }





    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }


    public function photos()
    {
        return $this->hasMany(PhotoModel::class, 'folder_id', 'id');
    }

    public function videos()
    {
        return $this->hasMany(VideoModel::class, 'folder_id', 'id');
    }

    public function link()
    {
        return $this->hasOne(LinkModel::class, 'folder_id', 'id');
    }


    public function usedStorageBytes(): int
    {
        $photoSize = $this->photos()->sum('size');
        $videoSize = $this->videos()->sum('size');

        return $photoSize + $videoSize;
    }

    public static function upgradeTrialFolders(int $userId): void
    {
        self::where('user_id', $userId)
            ->where('is_trial', 1)
            ->update([
                'is_trial' => 0,
                'updated_at' => now(),
            ]);
    }

}
