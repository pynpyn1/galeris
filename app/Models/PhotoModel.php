<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PhotoModel extends Model
{
    use HasFactory, SoftDeletes;


    protected $table = 'photo';
    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($photo) {
            $photo->public_code = Str::random(10);
        });
    }

    public function folder()
    {
        return $this->belongsTo(FolderModel::class, 'folder_id', 'id');
    }
}
