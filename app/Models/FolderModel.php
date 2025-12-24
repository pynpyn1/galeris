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
        return $this->hasOne(User::class, 'user_id', 'id');
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

    public function links()
    {
        return $this->hasOne(LinkModel::class, 'folder_id', 'id');
    }



}
