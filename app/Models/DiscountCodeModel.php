<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCodeModel extends Model
{
    use HasFactory;
    protected $table = 'discount_code';

    protected $fillable = [
        'code', 'type', 'value',
        'start_at', 'end_at',
        'quota', 'is_active'
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime',
        'is_active'=> 'boolean',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_discount_code')
                    ->withPivot('used_at')
                    ->withTimestamps();
    }
}
