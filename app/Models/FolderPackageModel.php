<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FolderPackageModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'folder_package';
    protected $guarded = [];



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function folder()
    {
        return $this->belongsTo(FolderModel::class, 'folder_id', 'id');
    }
    public function package()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
