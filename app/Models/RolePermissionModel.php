<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermissionModel extends Model
{
    use HasFactory;
    protected $table = 'role_permission';
    protected $fillable = ['name', 'slug'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;

        $slugBase = str_replace('-', '_', Str::slug($value));
        $slug = $slugBase;
        $i = 1;


        while (static::where('slug', $slug)
                     ->where('id', '!=', $this->id ?? 0)
                     ->exists()) {
            $slug = $slugBase . '_' . $i++;
        }

        $this->attributes['slug'] = $slug;
    }


    public function roleGroups()
    {
        return $this->belongsToMany(
            RoleGroupModel::class,
            'role_group_permission',
            'role_permission_id',
            'role_group_id'
        );
    }
}
