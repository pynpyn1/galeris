<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleGroupPermissionModel extends Model
{
    use HasFactory;
    protected $table = 'role_group_permission';
    protected $fillable = ['role_group_id', 'role_permission_id'];

    public function roleGroup()
    {
        return $this->belongsTo(RoleGroupModel::class, 'role_group_id');
    }

    public function rolePermission()
    {
        return $this->belongsTo(RolePermissionModel::class, 'role_permission_id');
    }
}
