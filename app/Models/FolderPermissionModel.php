<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FolderPermissionModel extends Model
{
    use HasFactory;

    protected $table = 'folder_permission';
    protected $guarded = [];

    public function folders()
    {
        return $this->hasOne(FolderModel::class, 'folder_id', 'id');
    }
    
    public function users()
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }
}
