<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleGroupModel extends Model
{
    use HasFactory;
    protected $table = 'role_group';
    protected $fillable = ['name'];

    public function permissions()
    {
        return $this->belongsToMany(
            RolePermissionModel::class,
            'role_group_permission',
            'role_group_id',
            'role_permission_id'
        );
    }
}
